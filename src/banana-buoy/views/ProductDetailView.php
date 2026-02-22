<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class ProductDetailView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'Product Details - Banana Buoy';
        parent::__construct();
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
                <a href="/banana-buoy/products/" role="button">← Back to Products</a>
            </article>
        <?php else:
            $imageUrl = htmlspecialchars($product['image_url']);
            $altText = htmlspecialchars($product['alt_text']);
        ?>
            <article>
                <nav aria-label="breadcrumb">
                    <ul>
                        <li><a href="/banana-buoy/products/">Products</a></li>
                        <li><?= htmlspecialchars($product['name']) ?></li>
                    </ul>
                </nav>

                <section>
                    <div class="grid banana-buoy-grid-card-vertical-layout">
                        <div>
                            <img
                                    src="<?= $imageUrl ?>"
                                    alt="<?= $altText ?>"
                                    class="banana-buoy-image-hero-square"
                            >
                        </div>

                        <div>
                            <hgroup>
                                <h1><?= htmlspecialchars($product['name']) ?></h1>
                                <h2><?= htmlspecialchars($product['origin_country']) ?></h2>
                            </hgroup>

                            <h3>
                                $<?= number_format($product['price'], 2) ?> <small>per lb</small>
                            </h3>

                            <section>
                                <h4>Taste Profile</h4>
                                <p><?= htmlspecialchars($product['taste_profile']) ?></p>
                            </section>

                            <section>
                                <h4>Health Benefits</h4>
                                <ul>
                                    <li><strong>Rich in Pectin Fiber:</strong> Supports digestive health and feeds beneficial gut bacteria</li>
                                    <li><strong>Natural Energy:</strong> Provides sustained energy through natural sugars and complex carbohydrates</li>
                                    <li><strong>Vitamins & Minerals:</strong> Excellent source of potassium, vitamin B6, and vitamin C</li>
                                    <li><strong>Resistant Starch:</strong> Green-tipped varieties help regulate blood sugar levels</li>
                                </ul>
                            </section>

                            <section>
                                <h4>Sustainability</h4>
                                <p>
                                    This banana was transported using our revolutionary hydrogen-powered
                                    refrigeration system. Through seawater PEM electrolysis, we maintain
                                    optimal temperature (13-14°C) while reducing carbon emissions by 90%
                                    compared to traditional diesel systems.
                                </p>
                            </section>

                            <div>
                                <button type="button" class="banana-buoy-width-100p">Add to Cart (Coming Soon)</button>
                                <a href="/banana-buoy/products/" role="button" class="secondary banana-buoy-width-100p">
                                    ← Back to All Products
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <section>
                    <h3>Nutrition Information</h3>
                    <p><small><em>Values are approximate per 100g of banana</em></small></p>
                    <div class="grid">
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

