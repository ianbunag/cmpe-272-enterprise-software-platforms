<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class ErrorView extends BaseView
{
    private string $errorTitle = 'Error';
    private string $errorMessage = 'An unexpected error occurred.';
    private int $errorCode = 500;

    public function __construct(
        string $title = 'Error',
        string $message = 'An unexpected error occurred.',
        int $code = 500
    ) {
        $this->pageTitle = 'Error - Banana Buoy';
        $this->errorTitle = $title;
        $this->errorMessage = $message;
        $this->errorCode = $code;
    }

    protected function renderContent(array $data = []): void
    {
        ?>
        <article style="text-align: center;">
            <hgroup>
                <h1>⚠️ <?= htmlspecialchars($this->errorTitle) ?></h1>
                <h2>Error <?= $this->errorCode ?></h2>
            </hgroup>

            <p style="font-size: 1.1rem; color: var(--muted-color); margin: 2rem 0;">
                <?= htmlspecialchars($this->errorMessage) ?>
            </p>

            <div style="margin: 3rem 0;">
                <a href="/banana-buoy/" role="button">
                    🏠 Return to Home
                </a>
                <button
                    role="button"
                    class="secondary"
                    onclick="location.reload();"
                    style="margin-left: 1rem;"
                >
                    🔄 Refresh Page
                </button>
            </div>

            <section style="margin-top: 3rem; padding: 2rem; background-color: var(--card-background-color); border-radius: 8px; text-align: left;">
                <h3>What Went Wrong?</h3>
                <p>
                    We encountered an error while processing your request. Here are some suggestions:
                </p>
                <ul>
                    <li>Check that the requested item exists</li>
                    <li>Verify the URL parameters are correct</li>
                    <li>Try refreshing the page</li>
                    <li>Return to the homepage and navigate using the menu</li>
                    <li>Contact us if the problem persists</li>
                </ul>
            </section>

            <section style="margin-top: 2rem;">
                <h3>Need Help?</h3>
                <p>
                    Visit our <a href="/banana-buoy/contact">Contact Page</a> to reach out, or
                    explore our <a href="/banana-buoy/">Homepage</a> to get started again.
                </p>
            </section>
        </article>
        <?php
    }
}

