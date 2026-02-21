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
     */
    protected function renderContent(array $data = []): void
    {
        $newsArticles = $data['news'] ?? [];
        ?>
        <article>
            <hgroup>
                <h1>📰 Latest News</h1>
                <h2>Hydrogen Technology & Banana Nutrition Research</h2>
            </hgroup>

            <p>
                Stay updated on our latest developments in sustainable hydrogen-powered
                refrigeration and the latest research on banana pectin and digestive health.
            </p>

            <?php if (empty($newsArticles)): ?>
                <p><em>No news articles available at this time.</em></p>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <?php foreach ($newsArticles as $article):
                        $imageUrl = $article['image_url'];
                        $altText = htmlspecialchars($article['alt_text']);
                        $excerpt = substr($article['content'], 0, 200) . '...';
                    ?>
                        <article style="margin: 0;">
                            <div class="grid" style="grid-template-columns: 300px 1fr; gap: 1.5rem;">
                                <div>
                                    <img
                                        src="<?= $imageUrl ?>"
                                        alt="<?= $altText ?>"
                                        style="width: 100%; height: 200px; object-fit: cover; border-radius: 4px;"
                                    >
                                </div>

                                <div>
                                    <header>
                                        <h3 style="margin-bottom: 0.5rem;">
                                            <a href="/banana-buoy/news/<?= $article['id'] ?>" style="text-decoration: none; color: inherit;">
                                                <?= htmlspecialchars($article['title']) ?>
                                            </a>
                                        </h3>
                                        <p style="margin: 0;">
                                            <small>
                                                📅 <?= date('F j, Y', strtotime($article['date_published'])) ?>
                                            </small>
                                        </p>
                                    </header>

                                    <p><?= htmlspecialchars($excerpt) ?></p>

                                    <footer>
                                        <a href="/banana-buoy/news/<?= $article['id'] ?>">
                                            Read Full Article →
                                        </a>
                                    </footer>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <section style="margin-top: 3rem; text-align: center; padding: 2rem; background-color: var(--card-background-color); border-radius: 8px;">
                <h3>Stay Informed</h3>
                <p>
                    Subscribe to our newsletter for the latest updates on hydrogen technology
                    innovations and nutritional research.
                </p>
                <form method="POST" style="margin: 1rem auto; display: flex; gap: 0.5rem;">
                    <input type="email" placeholder="your.email@example.com" required>
                    <button type="submit">Subscribe</button>
                </form>
            </section>
        </article>
        <?php
    }
}

