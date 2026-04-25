<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SeedAndUpdateUsersWithNewFields extends AbstractMigration
{
    public function change(): void
    {
        $this->execute(<<<SQL
            UPDATE users SET
                first_name = 'Admin',
                last_name = 'Admin',
                home_address = '123 Banana Blvd, Sunnyvale, CA',
                home_phone = '408-555-1000',
                cell_phone = '408-555-2000'
            WHERE username = 'admin';
        SQL);
        $this->execute(<<<SQL
            UPDATE users SET
                first_name = 'Mary',
                last_name = 'Smith',
                home_address = '456 Ocean Ave, San Jose, CA',
                home_phone = '408-555-1001',
                cell_phone = '408-555-2001'
            WHERE username = 'mary_smith';
        SQL);
        $this->execute(<<<SQL
            UPDATE users SET
                first_name = 'John',
                last_name = 'Wang',
                home_address = '789 Bay St, Santa Clara, CA',
                home_phone = '408-555-1002',
                cell_phone = '408-555-2002'
            WHERE username = 'john_wang';
        SQL);
        $this->execute(<<<SQL
            UPDATE users SET
                first_name = 'Alex',
                last_name = 'Bington',
                home_address = '321 Harbor Rd, Mountain View, CA',
                home_phone = '408-555-1003',
                cell_phone = '408-555-2003'
            WHERE username = 'alex_bington';
        SQL);
        $this->execute(<<<SQL
            UPDATE users SET
                first_name = 'Jane',
                last_name = 'Doe',
                home_address = '654 Pier Ln, Palo Alto, CA',
                home_phone = '408-555-1004',
                cell_phone = '408-555-2004'
            WHERE username = 'jane_doe';
        SQL);
        $this->execute(<<<SQL
            UPDATE users SET
                first_name = 'Mike',
                last_name = 'Johnson',
                home_address = '987 Dock Dr, Cupertino, CA',
                home_phone = '408-555-1005',
                cell_phone = '408-555-2005'
            WHERE username = 'mike_johnson';
        SQL);

        // Seed 15 new users with realistic data
        $password = password_hash('password123', PASSWORD_BCRYPT);
        $users = [
            ['emily_chen', 'Emily', 'Chen', 'emily.chen@example.com', '123 Seaside Dr, Santa Cruz, CA', '831-555-1000', '831-555-2000'],
            ['david_lee', 'David', 'Lee', 'david.lee@example.com', '234 Coral St, Monterey, CA', '831-555-1001', '831-555-2001'],
            ['sophia_kim', 'Sophia', 'Kim', 'sophia.kim@example.com', '345 Wave Ave, Pacifica, CA', '650-555-1002', '650-555-2002'],
            ['oliver_nguyen', 'Oliver', 'Nguyen', 'oliver.nguyen@example.com', '456 Surf Rd, Half Moon Bay, CA', '650-555-1003', '650-555-2003'],
            ['ava_patel', 'Ava', 'Patel', 'ava.patel@example.com', '567 Beach Blvd, San Mateo, CA', '650-555-1004', '650-555-2004'],
            ['liam_garcia', 'Liam', 'Garcia', 'liam.garcia@example.com', '678 Oceanic Dr, Redwood City, CA', '650-555-1005', '650-555-2005'],
            ['mia_rodriguez', 'Mia', 'Rodriguez', 'mia.rodriguez@example.com', '789 Lighthouse Ln, Foster City, CA', '650-555-1006', '650-555-2006'],
            ['lucas_martin', 'Lucas', 'Martin', 'lucas.martin@example.com', '890 Marina St, Burlingame, CA', '650-555-1007', '650-555-2007'],
            ['charlotte_clark', 'Charlotte', 'Clark', 'charlotte.clark@example.com', '901 Bayview Ave, Millbrae, CA', '650-555-1008', '650-555-2008'],
            ['benjamin_lopez', 'Benjamin', 'Lopez', 'benjamin.lopez@example.com', '101 Ocean Park, San Bruno, CA', '650-555-1009', '650-555-2009'],
            ['amelia_hall', 'Amelia', 'Hall', 'amelia.hall@example.com', '202 Seaview Dr, Daly City, CA', '415-555-1010', '415-555-2010'],
            ['henry_allen', 'Henry', 'Allen', 'henry.allen@example.com', '303 Coastline Rd, San Francisco, CA', '415-555-1011', '415-555-2011'],
            ['ella_scott', 'Ella', 'Scott', 'ella.scott@example.com', '404 Pier St, Sausalito, CA', '415-555-1012', '415-555-2012'],
            ['jackson_evans', 'Jackson', 'Evans', 'jackson.evans@example.com', '505 Harbor Ave, Tiburon, CA', '415-555-1013', '415-555-2013'],
            ['grace_morris', 'Grace', 'Morris', 'grace.morris@example.com', '606 Dockside Dr, Belvedere, CA', '415-555-1014', '415-555-2014'],
        ];
        foreach ($users as $user) {
            $this->execute(
                "INSERT INTO users (username, first_name, last_name, email, password_hash, role, home_address, home_phone, cell_phone) VALUES (" .
                "'{$user[0]}', '{$user[1]}', '{$user[2]}', '{$user[3]}', '$password', 'user', '{$user[4]}', '{$user[5]}', '{$user[6]}')"
            );
        }
    }
}
