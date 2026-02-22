<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class NewsDetailView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'News Article - Banana Buoy';
    }

    /**
     * @param array $data Array containing article data
     *                    - article: array{
     *                        id: int,
     *                        title: string,
     *                        content: string,
     *                        date_published: string,
     *                        image_url: string,
     *                        alt_text: string
     *                      }|null (null if article not found)
     */
    protected function renderContent(array $data = []): void
    {
        $article = $data['article'] ?? null;

        if (!$article): ?>
            <article>
                <header>
                    <h1>Article Not Found</h1>
                </header>
                <p>Sorry, the article you're looking for doesn't exist or has been removed.</p>
                <a href="/banana-buoy/news/" role="button">← Back to News</a>
            </article>
        <?php else:
            $imageUrl = htmlspecialchars($article['image_url']);
            $altText = htmlspecialchars($article['alt_text']);
        ?>
            <article>
                <nav aria-label="breadcrumb">
                    <ul>
                        <li><a href="/banana-buoy/news/">News</a></li>
                        <li><?= htmlspecialchars($article['title']) ?></li>
                    </ul>
                </nav>

                <section>
                    <header class="banana-buoy-text-align-center">
                        <h1><?= htmlspecialchars($article['title']) ?></h1>
                        <p>
                            <small>
                                📅 Published on <?= date('F j, Y', strtotime($article['date_published'])) ?>
                            </small>
                        </p>
                    </header>

                    <div>
                        <img
                                src="<?= $imageUrl ?>"
                                alt="<?= $altText ?>"
                                class="banana-buoy-image-hero-landscape"
                        >
                        <p class="banana-buoy-text-align-center">
                            <small><em><?= $altText ?></em></small>
                        </p>
                    </div>

                    <div>
                        <?php
                        // Split content into paragraphs for better readability
                        $paragraphs = explode('. ', $article['content']);
                        $currentParagraph = '';
                        $sentenceCount = 0;

                        foreach ($paragraphs as $sentence) {
                            $currentParagraph .= trim($sentence) . '. ';
                            $sentenceCount++;

                            // Create a new paragraph every 3-4 sentences
                            if ($sentenceCount >= 3) {
                                echo '<p>' . htmlspecialchars(trim($currentParagraph)) . '</p>';
                                $currentParagraph = '';
                                $sentenceCount = 0;
                            }
                        }

                        // Output any remaining text
                        if (!empty(trim($currentParagraph))) {
                            echo '<p>' . htmlspecialchars(trim($currentParagraph)) . '</p>';
                        }
                        ?>
                    </div>
                </section>

                <footer>
                    <div class="grid">
                        <div>
                            <a href="/banana-buoy/news/" role="button" class="secondary">
                                ← Back to All News
                            </a>
                        </div>
                        <div>
                            <strong>Share this article:</strong><br>
                            <small>
                                <a href="#" onclick="return false;">Twitter</a> |
                                <a href="#" onclick="return false;">Facebook</a> |
                                <a href="#" onclick="return false;">LinkedIn</a>
                            </small>
                        </div>
                    </div>
                </footer>
            </article>
        <?php endif;
    }
}

