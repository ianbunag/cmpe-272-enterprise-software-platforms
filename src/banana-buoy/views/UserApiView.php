<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseApiView.php';

class UserApiView extends BaseApiView
{
    /**
     * Render a list of names from user records
     *
     * @param array<int, array{username: string}> $users Array of user records
     */
    public function render($users): void
    {
        $names = [];

        foreach ($users as $user) {
            $names[] = $user['first_name'] . ' ' . $user['last_name'];
        }

        parent::render($names);
    }
}

