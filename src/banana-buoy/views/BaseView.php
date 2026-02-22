<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/../../models/VersionModel.php';

use Models\VersionModel;

abstract class BaseView
{
    protected string $title = 'Banana Buoy';
    protected string $pageTitle = '';

    /**
     * Render the complete page with header and footer
     */
    public function render(array $data = []): void
    {
        $this->renderHeader();
        $this->renderContent($data);
        $this->renderFooter();
    }

    /**
     * Render the header with navigation
     */
    protected function renderHeader(): void
    {
        $version = (new VersionModel())->gerVersion();

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= htmlspecialchars($this->pageTitle ?: $this->title) ?></title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
            <link rel="icon" type="image/x-icon" href="/static/banana-buoy/favicon.ico">
            <link rel="stylesheet" href="/../../static/banana-buoy/pico.css?version=<?= $version ?>">
            <link rel="stylesheet" href="/../../static/banana-buoy/styles.css?version=<?= $version ?>">
        </head>
        <body>
            <nav class="container-fluid">
                <a href="/banana-buoy/">
                    <img src="/../../static/banana-buoy/logo.png" class="banana-buoy-image-logo">
                </a>
                <ul>
                    <li><a href="/banana-buoy/">Home</a></li>
                    <li><a href="/banana-buoy/about/">About</a></li>
                    <li><a href="/banana-buoy/products/">Products</a></li>
                    <li><a href="/banana-buoy/news/">News</a></li>
                    <li><a href="/banana-buoy/contact/">Contact</a></li>
                </ul>
            </nav>
            <main class="container">
        <?php
    }

    /**
     * Render the page-specific content - must be implemented by child classes
     */
    abstract protected function renderContent(array $data = []): void;

    /**
     * Render the footer
     */
    protected function renderFooter(): void
    {
        ?>
            </main>
            <footer class="container">
                <p>
                    <small>
                        Powered by Seawater Hydrogen Electrolysis
                    </small>
                </p>
            </footer>
        </body>
        </html>
        <?php
    }
}

