<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SeedUsers extends AbstractMigration
{
    /**
     * Seed the users table with test data including admin user
     */
    public function up(): void
    {
        // Hash admin password
        $adminPassword = password_hash('admin', PASSWORD_BCRYPT);

        // Seed admin user
        $this->execute("
            INSERT INTO users (username, display_name, email, password_hash, role) VALUES
            ('admin', 'Administrator', 'admin.bananabuoy@ianbunag.dev', '$adminPassword', 'admin')
        ");

        // Hash user passwords
        $maryPassword = password_hash('password123', PASSWORD_BCRYPT);
        $johnPassword = password_hash('password123', PASSWORD_BCRYPT);
        $alexPassword = password_hash('password123', PASSWORD_BCRYPT);
        $janePassword = password_hash('password123', PASSWORD_BCRYPT);
        $mikePassword = password_hash('password123', PASSWORD_BCRYPT);

        // Seed test users
        $this->execute("
            INSERT INTO users (username, display_name, email, password_hash, role) VALUES
            ('mary_smith', 'Mary Smith', 'mary.smith@example.com', '$maryPassword', 'user'),
            ('john_wang', 'John Wang', 'john.wang@example.com', '$johnPassword', 'user'),
            ('alex_bington', 'Alex Bington', 'alex.bington@example.com', '$alexPassword', 'user'),
            ('jane_doe', 'Jane Doe', 'jane.doe@example.com', '$janePassword', 'user'),
            ('mike_johnson', 'Mike Johnson', 'mike.johnson@example.com', '$mikePassword', 'user')
        ");
    }

    /**
     * Rollback seed data
     */
    public function down(): void
    {
        $this->execute("DELETE FROM users");
    }
}

