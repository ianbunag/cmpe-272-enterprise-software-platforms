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
        <article class="banana-buoy-text-align-center">
            <section>
                <hgroup>
                    <h1>⚠️ <?= htmlspecialchars($this->errorTitle) ?></h1>
                    <h2>Error <?= $this->errorCode ?></h2>
                </hgroup>

                <p>
                    <?= htmlspecialchars($this->errorMessage) ?>
                </p>

                <div>
                    <button
                            role="button"
                            class="secondary"
                            onclick="location.reload();"
                    >
                        🔄 Refresh Page
                    </button>
                </div>
            </section>

            <section class="banana-buoy-text-align-left">
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

            <section>
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

