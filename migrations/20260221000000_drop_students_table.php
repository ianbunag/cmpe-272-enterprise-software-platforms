<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DropStudentsTable extends AbstractMigration
{
    /**
     * Drop the students table
     */
    public function change(): void
    {
        $this->table('students')->drop()->save();
    }
}

