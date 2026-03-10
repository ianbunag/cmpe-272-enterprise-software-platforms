<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class SecureView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'User List - Banana Buoy Secure Section';
        parent::__construct();
    }

    /**
     * @param array $data Array containing user data
     *                    - users: array<int, array{
     *                        id: int,
     *                        username: string,
     *                        display_name: string,
     *                        email: string,
     *                        role: string,
     *                        created_at: string
     *                      }>
     *                    - currentUser: array{
     *                        id: int,
     *                        username: string,
     *                        display_name: string,
     *                        email: string,
     *                        role: string,
     *                        created_at: string
     *                      }|null
     */
    protected function renderContent(array $data = []): void
    {
        $users = $data['users'] ?? [];
        $currentUser = $data['currentUser'] ?? null;
        ?>
        <article>
            <section>
                <hgroup>
                    <h1>🔒 Secure Section - User List</h1>
                    <h2>Current Website Users</h2>
                </hgroup>

                <?php if ($currentUser): ?>
                    <p>
                        <strong>Logged in as:</strong> <?= htmlspecialchars($currentUser['display_name']) ?>
                    </p>
                <?php endif; ?>

                <p>
                    Below is a complete list of all registered users on the Banana Buoy website.
                </p>
            </section>

            <section>
                <?php if (empty($users)): ?>
                    <p><em>No users available.</em></p>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th style="min-width: 50px;">ID</th>
                                    <th style="min-width: 120px;">Username</th>
                                    <th style="min-width: 140px;">Display Name</th>
                                    <th style="min-width: 160px;">Email</th>
                                    <th style="min-width: 80px;">Role</th>
                                    <th style="min-width: 150px;">Registered Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars((string)$user['id']) ?></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['display_name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars(ucfirst($user['role'])) ?></strong>
                                        </td>
                                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

            <section>
                <div class="banana-buoy-text-align-center">
                    <a href="/banana-buoy/secure/logout" role="button" class="secondary">
                        🚪 Logout
                    </a>
                </div>
            </section>
        </article>
        <?php
    }
}

