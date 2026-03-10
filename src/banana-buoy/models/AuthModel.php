<?php

namespace BananaBuoy\Models;

use PDO;
use PDOException;

require_once __DIR__ . '/DatabaseModel.php';

class AuthModel
{
    private PDO $db;
    private string $appSecret;

    public function __construct()
    {
        $database = new DatabaseModel();
        $this->db = $database->getConnection();
        $this->appSecret = getenv('APP_SECRET') ?: 'default-insecure-secret';
    }

    /**
     * Authenticate a user with username and password
     *
     * @return array{
     *     id: int,
     *     username: string,
     *     display_name: string,
     *     role: string
     * }|null User record if authenticated, null otherwise
     */
    public function authenticate(string $username, string $password): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, username, display_name, role, password_hash 
                FROM users 
                WHERE username = ?
            ");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($password, $user['password_hash'])) {
                return null;
            }

            return [
                'id' => (int)$user['id'],
                'username' => $user['username'],
                'display_name' => $user['display_name'],
                'role' => $user['role']
            ];
        } catch (PDOException $e) {
            error_log("Authentication error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate a signed authentication token
     *
     * @return string Base64-encoded signed token
     */
    public function generateToken(int $userId, string $role): string
    {
        $expiryTime = time() + 3600; // 1 hour expiry
        $payload = json_encode([
            'user_id' => $userId,
            'role' => $role,
            'exp' => $expiryTime
        ]);

        $signature = hash_hmac('sha256', $payload, $this->appSecret);
        $token = base64_encode($payload . '::' . $signature);

        return $token;
    }

    /**
     * Validate a signed authentication token
     *
     * @return array{
     *     user_id: int,
     *     role: string
     * }|null Token data if valid, null otherwise
     */
    public function validateToken(string $token): ?array
    {
        try {
            $decoded = base64_decode($token, true);
            if ($decoded === false) {
                return null;
            }

            $parts = explode('::', $decoded);
            if (count($parts) !== 2) {
                return null;
            }

            [$payload, $signature] = $parts;

            // Verify signature
            $expectedSignature = hash_hmac('sha256', $payload, $this->appSecret);
            if (!hash_equals($signature, $expectedSignature)) {
                return null;
            }

            // Decode and validate payload
            $data = json_decode($payload, true);
            if (!$data || !isset($data['user_id'], $data['role'], $data['exp'])) {
                return null;
            }

            // Check expiry
            if ($data['exp'] < time()) {
                return null;
            }

            return [
                'user_id' => $data['user_id'],
                'role' => $data['role']
            ];
        } catch (Exception $e) {
            error_log("Token validation error: " . $e->getMessage());
            return null;
        }
    }
}

