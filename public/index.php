<?php

echo "<h1>PHP/MySQL GCP Starter App</h1>";
echo "<p>Today is " . date('Y-m-d') . ".</p>";

try {
    $pdo = new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
        getenv('DB_USER'),
        getenv('DB_PASSWORD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "<p>Database connection: <span style='color:green'>OK</span></p>";
} catch (Exception $e) {
    echo "<p>Database connection: <span style='color:red'>FAILED</span>";
}
