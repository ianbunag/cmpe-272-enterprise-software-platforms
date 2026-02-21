<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class ProductDetailView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'Product Details - Banana Buoy';
    }

    protected function renderContent(array $data = []): void
    {
        $product = $data['product'] ?? null;

        if (!$product): ?>
            <article>
                <header>
                    <h1>Product Not Found</h1>
                </header>
                <p>Sorry, the product you're looking for doesn't exist or has been removed.</p>
                <a href="/banana-buoy/products" role="button">← Back to Products</a>
            </article>
        <?php else:
            $imageUrl = htmlspecialchars($product['image_url']);
            $altText = htmlspecialchars($product['alt_text']);
        ?>
            <article>
                <nav aria-label="breadcrumb" style="margin-bottom: 1rem;">
                    <ul style="padding: 0; list-style: none; display: flex; gap: 0.5rem;">
                        <li><a href="/banana-buoy/products">Products</a></li>
                        <li><?= htmlspecialchars($product['name']) ?></li>
                    </ul>
                </nav>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div>
                            <img
                                src="<?= $imageUrl ?>"
                                alt="<?= $altText ?>"
                                style="width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                            >
                    </div>

                    <div>
                        <hgroup>
                            <h1><?= htmlspecialchars($product['name']) ?></h1>
                            <h2><?= htmlspecialchars($product['origin_country']) ?></h2>
                        </hgroup>

                        <p style="font-size: 2rem; color: var(--primary); font-weight: bold; margin: 1rem 0;">
                            $<?= number_format($product['price'], 2) ?> <small style="font-size: 1rem; color: var(--muted-color);">per lb</small>
                        </p>

                        <section>
                            <h3>Taste Profile</h3>
                            <p><?= htmlspecialchars($product['taste_profile']) ?></p>
                        </section>

                        <section>
                            <h3>Health Benefits</h3>
                            <ul>
                                <li><strong>Rich in Pectin Fiber:</strong> Supports digestive health and feeds beneficial gut bacteria</li>
                                <li><strong>Natural Energy:</strong> Provides sustained energy through natural sugars and complex carbohydrates</li>
                                <li><strong>Vitamins & Minerals:</strong> Excellent source of potassium, vitamin B6, and vitamin C</li>
                                <li><strong>Resistant Starch:</strong> Green-tipped varieties help regulate blood sugar levels</li>
                            </ul>
                        </section>

                        <section>
                            <h3>Sustainability</h3>
                            <p>
                                This banana was transported using our revolutionary hydrogen-powered
                                refrigeration system. Through seawater PEM electrolysis, we maintain
                                optimal temperature (13-14°C) while reducing carbon emissions by 90%
                                compared to traditional diesel systems.
                            </p>
                        </section>

                        <div style="margin-top: 2rem;">
                            <button type="button" style="width: 100%;">Add to Cart (Coming Soon)</button>
                            <a href="/banana-buoy/products" role="button" class="secondary" style="width: 100%; margin-top: 0.5rem;">
                                ← Back to All Products
                            </a>
                        </div>
                    </div>
                </div>

                <section style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--muted-border-color);">
                    <h3>Nutrition Information</h3>
                    <p><small><em>Values are approximate per 100g of banana</em></small></p>
                    <div class="grid" style="grid-template-columns: repeat(4, 1fr);">
                        <div>
                            <strong>Calories</strong><br>
                            89 kcal
                        </div>
                        <div>
                            <strong>Fiber</strong><br>
                            2.6g
                        </div>
                        <div>
                            <strong>Potassium</strong><br>
                            358mg
                        </div>
                        <div>
                            <strong>Vitamin B6</strong><br>
                            0.4mg
                        </div>
                    </div>
                </section>
            </article>
        <?php endif;
    }
}

