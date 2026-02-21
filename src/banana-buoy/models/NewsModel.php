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
     * @return array<int, array{
     *     id: int,
     *     title: string,
     *     content: string,
     *     date_published: string,
     *     image_url: string,
     *     alt_text: string
     * }> Array of all news articles, empty array on error
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
     * @return array{
     *     id: int,
     *     title: string,
     *     content: string,
     *     date_published: string,
     *     image_url: string,
     *     alt_text: string
     * }|null News article record if found, null if not found or error occurs
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

