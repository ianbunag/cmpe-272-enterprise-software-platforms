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
     *     display_name: string,
     *     email: string,
     *     role: string,
     *     created_at: string
     * }> Array of all user records, empty array on error
     */
    public function getAll(): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, username, display_name, email, role, created_at 
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
     *     id: int,
     *     username: string,
     *     display_name: string,
     *     email: string,
     *     role: string,
     *     created_at: string
     * }|null User record if found, null otherwise
     */
    public function getById(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, username, display_name, email, role, created_at 
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
}

