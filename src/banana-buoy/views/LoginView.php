<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class LoginView extends BaseView
{
    private bool $showError = false;

    public function __construct(bool $showError = false)
    {
        $this->pageTitle = 'Login - Banana Buoy Secure Section';
        $this->showError = $showError;
        parent::__construct();
    }

    protected function renderContent(array $data = []): void
    {
        ?>
        <article>
            <section>
                <hgroup>
                    <h1>🔒 Secure Section Login</h1>
                    <h2>Administrator Access Required</h2>
                </hgroup>

                <?php if ($this->showError): ?>
                    <p style="color: #d32f2f; padding: 12px; border-left: 4px solid #d32f2f; margin: 16px 0;">
                        <strong>Invalid username or password</strong>
                    </p>
                <?php endif; ?>

                <form method="POST" action="/banana-buoy/secure/login">
                    <label for="username">
                        Username
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Enter your username"
                            required
                            autofocus
                        >
                    </label>

                    <label for="password">
                        Password
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >
                    </label>

                    <button type="submit">Login</button>
                </form>
            </section>

            <section>
                <h3>About the Secure Section</h3>
                <p>
                    This section contains sensitive information about Banana Buoy users and operations.
                    Only administrators with valid credentials can access this area.
                </p>
                <p>
                    <a href="/banana-buoy/">Return to Home</a>
                </p>
            </section>
        </article>
        <?php
    }
}

