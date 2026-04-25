<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class AddUserFieldsToUsersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users');
        $table
            ->addColumn('first_name', 'string', ['limit' => 100, 'null' => false, 'default' => ''])
            ->addColumn('last_name', 'string', ['limit' => 100, 'null' => false, 'default' => ''])
            ->addColumn('home_address', 'string', ['limit' => 255, 'null' => false, 'default' => ''])
            ->addColumn('home_phone', 'string', ['limit' => 32, 'null' => false, 'default' => ''])
            ->addColumn('cell_phone', 'string', ['limit' => 32, 'null' => false, 'default' => ''])
            ->removeColumn('display_name')
            ->update();
    }
}
