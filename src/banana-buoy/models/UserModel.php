<?php

namespace BananaBuoy\Models;

use PDO;
use PDOException;

require_once __DIR__ . '/DatabaseModel.php';

class UserModel
{
    private PDO $db;

    public function __construct()
    {
        $database = new DatabaseModel();
        $this->db = $database->getConnection();
    }

    /**
     * @return array<int, array{
     *     id: int,
     *     username: string,
     *     first_name: string,
     *     last_name: string,
     *     email: string,
     *     role: string,
     *     home_address: string,
     *     home_phone: string,
     *     cell_phone: string,
     *     created_at: string
     * }> Array of all user records, empty array on error
     */
    public function getAll(): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, username, first_name, last_name, email, role, home_address, home_phone, cell_phone, created_at 
                FROM users 
                ORDER BY created_at ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching users: " . $e->getMessage());
            return [];
        }
    }

    /**
     * @return array{
     * id: int,
     * username: string,
     * first_name: string,
     * last_name: string,
     * email: string,
     * role: string,
     * home_address: string,
     * home_phone: string,
     * cell_phone: string,
     * created_at: string
     * }|null User record if found, null otherwise
     */
    public function getById(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, username, first_name, last_name, email, role, home_address, home_phone, cell_phone, created_at 
                FROM users 
                WHERE id = ?
            ");
            $stmt->execute([$id]);
            return $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching user: " . $e->getMessage());
            return null;
        }
    }

    /**
     * @return array<int, array{
     *     id: int,
     *     username: string,
     *     first_name: string,
     *     last_name: string,
     *     email: string,
     *     role: string,
     *     home_address: string,
     *     home_phone: string,
     *     cell_phone: string,
     *     created_at: string
     * }> Array of filtered user records, empty array on error
     */
    public function searchUsers(string $query): array
    {
        try {
            $searchTerm = '%' . $query . '%';
            $stmt = $this->db->prepare("
                SELECT id, username, first_name, last_name, email, role, home_address, home_phone, cell_phone, created_at 
                FROM users 
                WHERE LOWER(first_name) LIKE LOWER(?)
                   OR LOWER(last_name) LIKE LOWER(?)
                   OR LOWER(email) LIKE LOWER(?)
                   OR LOWER(home_phone) LIKE LOWER(?)
                   OR LOWER(cell_phone) LIKE LOWER(?)
                ORDER BY created_at ASC
            ");
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error searching users: " . $e->getMessage());
            return [];
        }
    }

    public function createUser(string $username, string $email, string $password, string $firstName, string $lastName, string $homeAddress, string $homePhone, string $cellPhone): array
    {
        try {
            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                return ['success' => false, 'error' => 'Username already exists'];
            }

            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                return ['success' => false, 'error' => 'Email already exists'];
            }

            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $this->db->prepare("
                INSERT INTO users (username, email, password_hash, first_name, last_name, home_address, home_phone, cell_phone, role)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$username, $email, $passwordHash, $firstName, $lastName, $homeAddress, $homePhone, $cellPhone, 'user']);

            return ['success' => true, 'message' => 'User created successfully'];
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return ['success' => false, 'error' => 'Something went wrong. Please try again later.'];
        }
    }
}
