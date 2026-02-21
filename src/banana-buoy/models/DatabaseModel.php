<?php

namespace BananaBuoy\Models;

use PDO;
use PDOException;

class DatabaseModel
{
    private static ?PDO $instance = null;

    private string $host;
    private string $dbname;
    private string $username;
    private string $password;
    private int $port;

    public function __construct(
        string $host = null,
        string $dbname = null,
        string $username = null,
        string $password = null,
        int $port = 3306
    ) {
        $this->host = $host ?? getenv('DB_HOST');
        $this->dbname = $dbname ?? getenv('DB_NAME');
        $this->username = $username ?? getenv('DB_USER');
        $this->password = $password ?? getenv('DB_PASSWORD');
        $this->port = $port;
    }

    /**
     * Get a PDO database connection instance
     */
    public function getConnection(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";

                self::$instance = new PDO($dsn, $this->username, $this->password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                error_log("Database connection failed: " . $e->getMessage());
                throw new PDOException("Could not connect to database");
            }
        }

        return self::$instance;
    }

    /**
     * Close the database connection
     */
    public static function closeConnection(): void
    {
        self::$instance = null;
    }
}

