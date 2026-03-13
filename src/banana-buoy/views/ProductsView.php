<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class ProductsView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'Products - Banana Buoy';
        parent::__construct();
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
     *                      }> All products
     *                    - recentProducts: array<int, array{
     *                        id: int,
     *                        name: string,
     *                        origin_country: string,
     *                        taste_profile: string,
     *                        image_url: string,
     *                        alt_text: string,
     *                        price: string
     *                      }> Recently viewed products
     *                    - popularProducts: array<int, array{
     *                        id: int,
     *                        name: string,
     *                        origin_country: string,
     *                        taste_profile: string,
     *                        image_url: string,
     *                        alt_text: string,
     *                        price: string
     *                      }> Most visited products
     */
    protected function renderContent(array $data = []): void
    {
        $products = $data['products'] ?? [];
        $recentProducts = $data['recentProducts'] ?? [];
        $popularProducts = $data['popularProducts'] ?? [];
        ?>
        <article>
            <section>
                <hgroup>
                    <h1>🍌 Our Banana Collection</h1>
                    <h2>30+ Premium Varieties from Around the World</h2>
                </hgroup>

                <p>
                    Explore our exotic banana selection, all transported using sustainable
                    hydrogen-powered refrigeration to preserve maximum freshness and nutrition.
                </p>
            </section>

            <!-- Recently Viewed Section -->
            <?php if (!empty($recentProducts)): ?>
                <section>
                    <h3>📋 Recently Viewed</h3>
                    <div class="grid banana-buoy-grid-card-horizontal-layout">
                        <?php $this->renderProductCards($recentProducts); ?>
                    </div>
                </section>
                <hr>
            <?php endif; ?>

            <!-- Most Popular Section -->
            <?php if (!empty($popularProducts)): ?>
                <section>
                    <h3>⭐ Most Popular</h3>
                    <div class="grid banana-buoy-grid-card-horizontal-layout">
                        <?php $this->renderProductCards($popularProducts); ?>
                    </div>
                </section>
                <hr>
            <?php endif; ?>

            <!-- All Products Section -->
            <section>
                <h3>🌍 All Products</h3>
                <?php if (empty($products)): ?>
                    <p><em>No products available at this time.</em></p>
                <?php else: ?>
                    <div class="grid banana-buoy-grid-card-horizontal-layout">
                        <?php $this->renderProductCards($products); ?>
                    </div>
                <?php endif; ?>
            </section>

            <section class="banana-buoy-text-align-center">
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

    /**
     * Render product cards for a given list of products.
     *
     * @param array<int, array{
     *     id: int,
     *     name: string,
     *     origin_country: string,
     *     taste_profile: string,
     *     image_url: string,
     *     alt_text: string,
     *     price: string
     * }> $products Array of product records to render
     */
    private function renderProductCards(array $products): void
    {
        foreach ($products as $product):
            $imageUrl = htmlspecialchars($product['image_url']);
            $altText = htmlspecialchars($product['alt_text']);
            ?>
            <article class="banana-buoy-margin-0">
                <header>
                    <img
                            src="<?= $imageUrl ?>"
                            alt="<?= $altText ?>"
                            class="banana-buoy-image-thumbnail"
                    >
                    <hgroup>
                        <h3>
                            <?= htmlspecialchars($product['name']) ?>
                        </h3>
                        <p>
                            <small><?= htmlspecialchars($product['origin_country']) ?></small>
                        </p>
                    </hgroup>
                </header>

                <p>
                    <small><?= htmlspecialchars($product['taste_profile']) ?></small>
                </p>

                <footer class="banana-buoy-layout-space-between">
                    <strong>
                        $<?= number_format($product['price'], 2) ?>/lb
                    </strong>
                    <a href="/banana-buoy/products/<?= $product['id'] ?>" role="button" class="secondary">
                        View Details
                    </a>
                </footer>
            </article>
            <?php
        endforeach;
    }
}

