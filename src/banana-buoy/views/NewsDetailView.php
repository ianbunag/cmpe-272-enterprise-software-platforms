<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class NewsDetailView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'News Article - Banana Buoy';
    }

    protected function renderContent(array $data = []): void
    {
        $article = $data['article'] ?? null;

        if (!$article): ?>
            <article>
                <header>
                    <h1>Article Not Found</h1>
                </header>
                <p>Sorry, the article you're looking for doesn't exist or has been removed.</p>
                <a href="/banana-buoy/news" role="button">← Back to News</a>
            </article>
        <?php else:
            $imageUrl = !empty($article['image_url'])
                ? htmlspecialchars($article['image_url'])
                : '../../static/placeholder-news.svg';
            $altText = htmlspecialchars($article['alt_text']);
        ?>
            <article>
                <nav aria-label="breadcrumb" style="margin-bottom: 1rem;">
                    <ul style="padding: 0; list-style: none; display: flex; gap: 0.5rem;">
                        <li><a href="/banana-buoy/news">News</a></li>
                        <li>/</li>
                        <li><?= htmlspecialchars($article['title']) ?></li>
                    </ul>
                </nav>

                <header style="text-align: center; margin-bottom: 2rem;">
                    <h1><?= htmlspecialchars($article['title']) ?></h1>
                    <p>
                        <small>
                            📅 Published on <?= date('F j, Y', strtotime($article['date_published'])) ?>
                        </small>
                    </p>
                </header>

                <div style="margin: 2rem 0;">
                    <img
                        src="<?= $imageUrl ?>"
                        alt="<?= $altText ?>"
                        style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                    >
                    <p style="text-align: center; margin-top: 0.5rem;">
                        <small><em><?= $altText ?></em></small>
                    </p>
                </div>

                <div style="max-width: 800px; margin: 0 auto; font-size: 1.1rem; line-height: 1.8;">
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

                <footer style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--muted-border-color);">
                    <div class="grid">
                        <div>
                            <a href="/banana-buoy/news" role="button" class="secondary">
                                ← Back to All News
                            </a>
                        </div>
                        <div style="text-align: right;">
                            <strong>Share this article:</strong><br>
                            <small>
                                <a href="#" onclick="return false;">Twitter</a> |
                                <a href="#" onclick="return false;">Facebook</a> |
                                <a href="#" onclick="return false;">LinkedIn</a>
                            </small>
                        </div>
                    </div>
                </footer>

                <section style="margin-top: 2rem; padding: 1.5rem; background-color: var(--card-background-color); border-radius: 8px;">
                    <h3>Related Topics</h3>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <?php
                        $tags = [];
                        if (stripos($article['title'], 'hydrogen') !== false || stripos($article['content'], 'hydrogen') !== false) {
                            $tags[] = 'Hydrogen Technology';
                        }
                        if (stripos($article['title'], 'pectin') !== false || stripos($article['content'], 'pectin') !== false) {
                            $tags[] = 'Banana Pectin';
                        }
                        if (stripos($article['content'], 'electrolysis') !== false) {
                            $tags[] = 'PEM Electrolysis';
                        }
                        if (stripos($article['content'], 'digestive') !== false || stripos($article['content'], 'fiber') !== false) {
                            $tags[] = 'Digestive Health';
                        }
                        if (stripos($article['content'], 'refrigeration') !== false || stripos($article['content'], 'cold') !== false) {
                            $tags[] = 'Cold Storage';
                        }

                        foreach ($tags as $tag): ?>
                            <span style="padding: 0.3rem 0.8rem; background-color: var(--primary); color: var(--contrast); border-radius: 20px; font-size: 0.85rem;">
                                <?= htmlspecialchars($tag) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </section>
            </article>
        <?php endif;
    }
}

