<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class HomeView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'Home - Banana Buoy';
    }

    protected function renderContent(array $data = []): void
    {
        ?>
        <section>
            <hgroup>
                <h1>🍌 Welcome to Banana Buoy</h1>
                <h2>Sustainable Banana Transport Powered by Hydrogen</h2>
            </hgroup>

            <img src="../../static/hero-home.svg"
                 alt="Hero image showing a hydrogen-powered banana transport vessel with sustainable technology"
                 class="banana-buoy-image-hero-landscape">
        </section>

        <section>
            <p>
                Discover the world's finest bananas, transported fresh using cutting-edge
                <strong>Seawater Hydrogen Electrolysis</strong> technology for refrigeration.
            </p>

            <div class="grid">
                <div>
                    <article>
                        <header>
                            <strong>🌊 Eco-Friendly</strong>
                        </header>
                        <p>Our hydrogen-powered cold storage uses renewable seawater electrolysis,
                           reducing carbon emissions by 90%.</p>
                    </article>
                </div>
                <div>
                    <article>
                        <header>
                            <strong>🍌 Premium Quality</strong>
                        </header>
                        <p>30+ varieties of exotic bananas from around the world,
                           delivered at peak freshness.</p>
                    </article>
                </div>
                <div>
                    <article>
                        <header>
                            <strong>💚 Health Benefits</strong>
                        </header>
                        <p>Rich in banana pectin fiber for improved digestion and gut health.</p>
                    </article>
                </div>
            </div>

            <div class="banana-buoy-text-align-center">
                <a href="/banana-buoy/products/" role="button">Explore Our Bananas</a>
                <a href="/banana-buoy/news/" role="button" class="secondary">Latest News</a>
            </div>
        </section>
        <?php
    }
}

