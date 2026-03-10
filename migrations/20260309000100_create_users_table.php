<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    /**
     * Create the users table for authentication and authorization
     */
    public function change(): void
    {
        $users = $this->table('users');
        $users->addColumn('username', 'string', ['limit' => 50])
              ->addIndex(['username'], ['unique' => true])
              ->addColumn('display_name', 'string', ['limit' => 100])
              ->addColumn('email', 'string', ['limit' => 100])
              ->addColumn('password_hash', 'string', ['limit' => 255])
              ->addColumn('role', 'enum', ['values' => ['user', 'admin']])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->create();
    }
}

