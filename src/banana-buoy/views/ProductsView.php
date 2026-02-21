<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class ProductsView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'Products - Banana Buoy';
    }

    /**
     * @param array $data Array containing product data
     *                    - products: array<int, array{
     *                        id: int,
     *                        name: string,
     *                        origin_country: string,
     *                        taste_profile: string,
     *                        image_url: string,
     *                        alt_text: string,
     *                        price: string
     *                      }>
     */
    protected function renderContent(array $data = []): void
    {
        $products = $data['products'] ?? [];
        ?>
        <article>
            <hgroup>
                <h1>🍌 Our Banana Collection</h1>
                <h2>30+ Premium Varieties from Around the World</h2>
            </hgroup>

            <p>
                Explore our exotic banana selection, all transported using sustainable
                hydrogen-powered refrigeration to preserve maximum freshness and nutrition.
            </p>

            <?php if (empty($products)): ?>
                <p><em>No products available at this time.</em></p>
            <?php else: ?>
                <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                    <?php foreach ($products as $product): ?>
                        <article style="margin: 0;">
                            <?php
                            $imageUrl = htmlspecialchars($product['image_url']);
                            $altText = htmlspecialchars($product['alt_text']);
                            ?>
                            <img
                                src="<?= $imageUrl ?>"
                                alt="<?= $altText ?>"
                                style="width: 100%; height: 200px; object-fit: cover; border-radius: 4px;"
                            >

                            <header style="margin-top: 1rem;">
                                <h3 style="margin-bottom: 0.5rem;">
                                    <?= htmlspecialchars($product['name']) ?>
                                </h3>
                                <p style="margin: 0;">
                                    <small><?= htmlspecialchars($product['origin_country']) ?></small>
                                </p>
                            </header>

                            <p style="margin: 0.5rem 0;">
                                <small><?= htmlspecialchars($product['taste_profile']) ?></small>
                            </p>

                            <footer style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                                <strong style="color: var(--primary);">
                                    $<?= number_format($product['price'], 2) ?>/lb
                                </strong>
                                <a href="/banana-buoy/products/<?= $product['id'] ?>" role="button" class="secondary" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.9rem;">
                                    View Details
                                </a>
                            </footer>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <section style="margin-top: 3rem; text-align: center;">
                <h3>Why Choose Banana Buoy?</h3>
                <div class="grid">
                    <div>
                        <h4>🌊 Sustainable Transport</h4>
                        <p>Hydrogen-powered refrigeration with 90% lower emissions</p>
                    </div>
                    <div>
                        <h4>🍌 Peak Freshness</h4>
                        <p>Precision temperature control preserves nutrients and flavor</p>
                    </div>
                    <div>
                        <h4>💚 Health Benefits</h4>
                        <p>Rich in banana pectin fiber for digestive wellness</p>
                    </div>
                </div>
            </section>
        </article>
        <?php
    }
}

