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
     *                        home_address: string,
     *                        home_phone: string,
     *                        cell_phone: string,
     *                        created_at: string
     *                      }>
     *                    - currentUser: array{
     *                        id: int,
     *                        username: string,
     *                        first_name: string,
     *                        last_name: string,
     *                        email: string,
     *                        role: string,
     *                        home_address: string,
     *                        home_phone: string,
     *                        cell_phone: string,
     *                        created_at: string
     *                      }|null
     *                    - external_users: array<int, array{
     *                        name: string,
     *                        partner_url: string
     *                      }>
     *                    - showSuccess: bool
     */
    protected function renderContent(array $data = []): void
    {
        $users = $data['users'] ?? [];
        $currentUser = $data['currentUser'] ?? null;
        $searchQuery = $data['searchQuery'] ?? '';
        $showSuccess = $data['showSuccess'] ?? false;
        ?>
        <?php if ($showSuccess): ?>
        <div class="banana-buoy-alert-info">
            User created successfully.
        </div>
        <?php endif; ?>
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
                    <form>
                        <br>
                        <button type="button" onclick="window.location.href='/banana-buoy/secure/create-user';">Create User</button>
                    </form>
                </hgroup>
            </section>

            <section>
                <form method="get" class="grid" style="grid-template-columns: 2fr 1fr 1fr">
                    <label for="search-input" style="display: none;">Search Users</label>
                    <input
                        id="search-input"
                        type="text"
                        name="q"
                        placeholder="Search by name, email, or phone..."
                        value="<?= htmlspecialchars($searchQuery) ?>"
                    />
                    <button type="submit">🔍 Search</button>
                    <button type="reset" onclick="window.location.href='/banana-buoy/secure/';">Clear</button>
                </form>
                <?php if (!empty($searchQuery)): ?>
                    <p><em>Search results for: <strong><?= htmlspecialchars($searchQuery) ?></strong></em></p>
                <?php endif; ?>
                <?php if (empty($users)): ?>
                    <p><em><?= !empty($searchQuery) ? 'No users found matching your search.' : 'No users available.' ?></em></p>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th style="min-width: 50px;">ID</th>
                                    <th style="min-width: 150px;">Username</th>
                                    <th style="min-width: 150px;">First Name</th>
                                    <th style="min-width: 150px;">Last Name</th>
                                    <th style="min-width: 150px;">Email</th>
                                    <th style="min-width: 200px;">Home Address</th>
                                    <th style="min-width: 200px;">Home Phone</th>
                                    <th style="min-width: 200px;">Cell Phone</th>
                                    <th style="min-width: 100px;">Role</th>
                                    <th style="min-width: 200px;">Registered Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars((string)$user['id']) ?></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['first_name']) ?></td>
                                        <td><?= htmlspecialchars($user['last_name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['home_address']) ?></td>
                                        <td><?= htmlspecialchars($user['home_phone']) ?></td>
                                        <td><?= htmlspecialchars($user['cell_phone']) ?></td>
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

