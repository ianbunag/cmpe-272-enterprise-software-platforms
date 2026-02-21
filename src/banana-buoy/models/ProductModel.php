<?php

namespace BananaBuoy\Models;

use PDO;
use PDOException;

require_once __DIR__ . '/DatabaseModel.php';

class ProductModel
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
     *     name: string,
     *     origin_country: string,
     *     taste_profile: string,
     *     image_url: string,
     *     alt_text: string,
     *     price: string
     * }> Array of all product records, empty array on error
     */
    public function getAll(): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, name, origin_country, taste_profile, image_url, alt_text, price 
                FROM products 
                ORDER BY name ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }

    /**
     * @return array{
     *     id: int,
     *     name: string,
     *     origin_country: string,
     *     taste_profile: string,
     *     image_url: string,
     *     alt_text: string,
     *     price: string
     * }|null Product record if found, null if not found or error occurs
     */
    public function getById(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, name, origin_country, taste_profile, image_url, alt_text, price 
                FROM products 
                WHERE id = :id
            ");
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch();

            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching product: " . $e->getMessage());
            return null;
        }
    }
}

