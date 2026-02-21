<?php

namespace BananaBuoy\Views;

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
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= htmlspecialchars($this->pageTitle ?: $this->title) ?></title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
            <link rel="stylesheet" href="../../static/banana-buoy.css">
            <style>
                /* Inline styles for dynamic content only */
            </style>
        </head>
        <body>
            <nav class="container-fluid">
                <ul>
                    <li>
                        <a href="/banana-buoy/" style="text-decoration: none; display: flex; align-items: center; gap: 1rem; color: inherit;">
                            <img src="../../static/banana-buoy-logo.svg"
                                 alt="Banana Buoy Logo - A yellow buoy with a banana icon representing sustainable fruit transport"
                                 class="logo">
                            <strong>Banana Buoy</strong>
                        </a>
                    </li>
                </ul>
                <ul>
                    <li><a href="/banana-buoy/">Home</a></li>
                    <li><a href="/banana-buoy/about">About</a></li>
                    <li><a href="/banana-buoy/products">Products</a></li>
                    <li><a href="/banana-buoy/news">News</a></li>
                    <li><a href="/banana-buoy/contact">Contact</a></li>
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

