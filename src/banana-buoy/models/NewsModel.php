<?php

namespace BananaBuoy\Models;

use PDO;
use PDOException;

require_once __DIR__ . '/DatabaseModel.php';

class NewsModel
{
    private PDO $db;

    public function __construct()
    {
        $database = new DatabaseModel();
        $this->db = $database->getConnection();
    }

    /**
     * Get all news articles
     */
    public function getAll(): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, title, content, date_published, image_url, alt_text 
                FROM news 
                ORDER BY date_published DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching news: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a news article by ID
     */
    public function getById(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, title, content, date_published, image_url, alt_text 
                FROM news 
                WHERE id = :id
            ");
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch();

            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching news article: " . $e->getMessage());
            return null;
        }
    }
}

