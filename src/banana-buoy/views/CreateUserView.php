<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class CreateUserView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'Create User - Banana Buoy Secure Section';
        parent::__construct();
    }

    /**
     * @param array $data Array containing:
     *                    - error: string|null Error message if form submission failed
     *                    - formData: array{
     *                        username: string,
     *                        email: string,
     *                        first_name: string,
     *                        last_name: string,
     *                        home_address: string,
     *                        home_phone: string,
     *                        cell_phone: string,
     *                      } Previous form values to retain
     */
    protected function renderContent(array $data = []): void
    {
        $error = $data['error'] ?? null;
        $formData = $data['formData'] ?? [];
        ?>
        <article>
            <section>
                <br>
                <hgroup>
                    <h1>🔒 Create New User</h1>
                </hgroup>
                <a href="/banana-buoy/secure/" role="button" class="secondary">← Back to User List</a>
            </section>

            <?php if (!empty($error)): ?>
                <div class="banana-buoy-alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <article>
                <section>
                    <form method="POST">
                        <div class="grid">
                            <div>
                                <label for="username">
                                    Username
                                    <input
                                        id="username"
                                        type="text"
                                        name="username"
                                        placeholder="Enter username"
                                        value="<?= htmlspecialchars($formData['username'] ?? '') ?>"
                                        required
                                    />
                                </label>
                            </div>
                            <div>
                                <label for="email">
                                    Email
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        placeholder="Enter email"
                                        value="<?= htmlspecialchars($formData['email'] ?? '') ?>"
                                        required
                                    />
                                </label>
                            </div>
                        </div>

                        <label for="password">
                            Password
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Enter password"
                                required
                            />
                        </label>

                        <div class="grid">
                            <div>
                                <label for="first_name">
                                    First Name
                                    <input
                                        id="first_name"
                                        type="text"
                                        name="first_name"
                                        placeholder="Enter first name"
                                        value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>"
                                        required
                                    />
                                </label>
                            </div>
                            <div>
                                <label for="last_name">
                                    Last Name
                                    <input
                                        id="last_name"
                                        type="text"
                                        name="last_name"
                                        placeholder="Enter last name"
                                        value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>"
                                        required
                                    />
                                </label>
                            </div>
                        </div>

                        <label for="home_address">
                            Home Address
                            <input
                                id="home_address"
                                type="text"
                                name="home_address"
                                placeholder="Enter home address"
                                value="<?= htmlspecialchars($formData['home_address'] ?? '') ?>"
                                required
                            />
                        </label>

                        <div class="grid">
                            <div>
                                <label for="home_phone">
                                    Home Phone
                                    <input
                                        id="home_phone"
                                        type="tel"
                                        name="home_phone"
                                        placeholder="Enter home phone"
                                        value="<?= htmlspecialchars($formData['home_phone'] ?? '') ?>"
                                        required
                                    />
                                </label>
                            </div>
                            <div>
                                <label for="cell_phone">
                                    Cell Phone
                                    <input
                                        id="cell_phone"
                                        type="tel"
                                        name="cell_phone"
                                        placeholder="Enter cell phone"
                                        value="<?= htmlspecialchars($formData['cell_phone'] ?? '') ?>"
                                        required
                                    />
                                </label>
                            </div>
                        </div>

                        <div class="grid">
                            <button type="submit">Create</button>
                            <button type="reset" onclick="window.location.href='/banana-buoy/secure/'">Cancel</button>
                        </div>
                    </form>
                </section>
            </article>
        </article>
        <?php
    }
}

