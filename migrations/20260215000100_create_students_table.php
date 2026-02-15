<?php
require_once 'vendor/autoload.php';

use Phinx\Migration\AbstractMigration;

class CreateStudentsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('students')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
