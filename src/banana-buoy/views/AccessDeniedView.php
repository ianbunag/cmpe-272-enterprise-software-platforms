<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class AccessDeniedView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'Access Denied - Banana Buoy Secure Section';
        parent::__construct();
    }

    protected function renderContent(array $data = []): void
    {
        $currentUser = $data['currentUser'] ?? null;
        ?>
        <article class="banana-buoy-text-align-center">
            <section>
                <hgroup>
                    <h1>🚫 Access Denied</h1>
                    <h2>Insufficient Permissions</h2>
                </hgroup>

                <?php if ($currentUser): ?>
                    <p>
                        <strong>Logged in as:</strong> <?= htmlspecialchars($currentUser['display_name']) ?>
                    </p>
                <?php endif; ?>

                <p>
                    <strong>You do not have access to this resource.</strong>
                </p>

                <p>
                    The secure section is restricted to administrators only.
                    Your current account does not have the required permissions.
                </p>

                <div>
                    <a href="/banana-buoy/" role="button">
                        🏠 Return to Home
                    </a>
                    <a href="/banana-buoy/secure/logout" role="button" class="secondary">
                        🚪 Logout
                    </a>
                </div>
            </section>
        </article>
        <?php
    }
}

