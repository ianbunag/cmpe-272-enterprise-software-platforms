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
     *                        first_name: string,
     *                        last_name: string,
     *                        email: string,
     *                        role: string,
     *                        created_at: string
     *                      }>
     *                    - currentUser: array{
     *                        id: int,
     *                        username: string,
     *                        first_name: string,
     *                        last_name: string,
     *                        email: string,
     *                        role: string,
     *                        created_at: string
     *                      }|null
     *                    - external_users: array<int, array{
     *                        name: string,
     *                        partner_url: string
     *                      }>
     */
    protected function renderContent(array $data = []): void
    {
        $users = $data['users'] ?? [];
        $currentUser = $data['currentUser'] ?? null;
        ?>
        <article>
            <section>
                <br>
                <hgroup>
                    <h1>🔒 Secure Section - User List</h1>
                </hgroup>

                <?php if ($currentUser): ?>
                    <p>
                        <strong>Logged in as:</strong> <?= htmlspecialchars($currentUser['first_name'] . ' ' . $currentUser['last_name']) ?>
                    </p>
                    <a href="/banana-buoy/secure/logout" role="button" class="secondary">
                        🚪 Logout
                    </a>
                <?php endif; ?>

                <br>
                <br>
                <hgroup>
                    <h2>Current Website Users</h2>
                    <p>
                        Below is a complete list of all registered users on the Banana Buoy website.
                    </p>
                </hgroup>
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
                                        <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
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
        </article>

        <?php if (!empty($data['external_users'])): ?>
        <article>
            <section>
                <hgroup>
                    <h2>Partner Users</h2>
                </hgroup>
                <p>Users from partner websites:</p>
            </section>

            <section>
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th style="min-width: 140px;">Display Name</th>
                                <th style="min-width: 180px;">Partner Website</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['external_users'] as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars(is_array($user) && isset($user['name']) ? $user['name'] : (is_string($user) ? $user : 'Invalid user data')) ?></td>
                                    <td><?= htmlspecialchars(is_array($user) && isset($user['partner_url']) ? $user['partner_url'] : 'Unknown') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </article>
        <?php endif; ?>
        <?php
    }
}

