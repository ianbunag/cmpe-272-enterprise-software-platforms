<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseApiView.php';

class UserApiView extends BaseApiView
{
    /**
     * Render a list of usernames from user records
     *
     * @param array<int, array{username: string}> $users Array of user records
     */
    public function render($users): void
    {
        $usernames = array_column($users, 'username');
        parent::render($usernames);
    }
}

