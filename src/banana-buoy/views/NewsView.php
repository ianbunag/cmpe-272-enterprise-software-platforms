<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class NewsView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'News - Banana Buoy';
    }

    /**
     * @param array $data Array containing news articles
     *                    - news: array<int, array{
     *                        id: int,
     *                        title: string,
     *                        content: string,
     *                        date_published: string,
     *                        image_url: string,
     *                        alt_text: string
     *                      }>
     *                    - subscribed (bool): Whether newsletter subscription was successful
     */
    protected function renderContent(array $data = []): void
    {
        $newsArticles = $data['news'] ?? [];
        $subscribed = $data['subscribed'] ?? false;
        ?>
        <?php if ($subscribed): ?>
            <div class="banana-buoy-alert-info">
                <strong>Thank you!</strong> You've successfully subscribed to our newsletter.
            </div>
        <?php endif; ?>

        <article>
            <section>
                <hgroup>
                    <h1>📰 Latest News</h1>
                    <h2>Hydrogen Technology & Banana Nutrition Research</h2>
                </hgroup>

                <p>
                    Stay updated on our latest developments in sustainable hydrogen-powered
                    refrigeration and the latest research on banana pectin and digestive health.
                </p>
            </section>

            <section>
                <?php if (empty($newsArticles)): ?>
                    <p><em>No news articles available at this time.</em></p>
                <?php else: ?>
                    <div>
                        <?php foreach ($newsArticles as $article):
                            $imageUrl = $article['image_url'];
                            $altText = htmlspecialchars($article['alt_text']);
                            $excerpt = substr($article['content'], 0, 200) . '...';
                            ?>
                            <article>
                                <div class="grid banana-buoy-grid-card-vertical-layout">
                                    <div>
                                        <img
                                                src="<?= $imageUrl ?>"
                                                alt="<?= $altText ?>"
                                                class="banana-buoy-image-thumbnail"
                                        >
                                    </div>

                                    <div>
                                        <header>
                                            <h3>
                                                <a href="/banana-buoy/news/<?= $article['id'] ?>/">
                                                    <?= htmlspecialchars($article['title']) ?>
                                                </a>
                                            </h3>
                                            <p>
                                                <small>
                                                    📅 <?= date('F j, Y', strtotime($article['date_published'])) ?>
                                                </small>
                                            </p>
                                        </header>

                                        <p><?= htmlspecialchars($excerpt) ?></p>

                                        <footer>
                                            <a href="/banana-buoy/news/<?= $article['id'] ?>/">
                                                Read Full Article →
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <section class="banana-buoy-text-align-center">
                <h3>Stay Informed</h3>
                <p>
                    Subscribe to our newsletter for the latest updates on hydrogen technology
                    innovations and nutritional research.
                </p>
                <form method="POST" action="/banana-buoy/news/" class="grid">
                    <input type="email" name="email" placeholder="your.email@example.com" required>
                    <button type="submit">Subscribe</button>
                </form>
            </section>
        </article>
        <?php
    }
}

