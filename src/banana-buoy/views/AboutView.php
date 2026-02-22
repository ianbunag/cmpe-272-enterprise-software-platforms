<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class AboutView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'About - Banana Buoy';
        parent::__construct();
    }

    protected function renderContent(array $data = []): void
    {
        ?>
        <article>
            <section>
                <hgroup>
                    <h1>About Banana Buoy</h1>
                    <h2>Sustainable Banana Transport Through Clean Energy Innovation</h2>
                </hgroup>

                <img src="../../static/banana-buoy/hero-about.webp?version=<?= $this->version ?>"
                     alt="Illustration of seawater electrolysis process converting water to hydrogen fuel for sustainable transport"
                     class="banana-buoy-image-hero-landscape">
            </section>

            <section>
                <h3>🌊 Our Mission</h3>
                <p>
                    Banana Buoy revolutionizes the global banana supply chain by combining
                    cutting-edge hydrogen technology with a commitment to delivering the world's
                    finest banana varieties. We believe that sustainable practices and premium
                    quality are not mutually exclusive—they're essential partners.
                </p>
            </section>

            <section>
                <h3>⚡ The Science: Seawater → Electrolysis → Fuel → Cold Storage</h3>

                <div class="grid">
                    <article>
                        <header><strong>Step 1: Seawater Collection</strong></header>
                        <p>
                            Our vessels are equipped with advanced filtration systems that
                            collect and purify seawater. This abundant, renewable resource
                            becomes the feedstock for our energy generation.
                        </p>
                    </article>

                    <article>
                        <header><strong>Step 2: PEM Electrolysis</strong></header>
                        <p>
                            Through Proton Exchange Membrane (PEM) electrolysis, we split H₂O
                            molecules using electrical current. The cathode produces pure hydrogen
                            gas (H₂), while the anode releases oxygen (O₂). The PEM ensures only
                            hydrogen ions pass through, creating 99.999% pure hydrogen fuel.
                        </p>
                    </article>

                    <article>
                        <header><strong>Step 3: Hydrogen Fuel Cells</strong></header>
                        <p>
                            The hydrogen is stored in carbon-fiber tanks and fed into fuel cells
                            that generate electricity. This clean electrical power drives our
                            refrigeration systems with zero emissions—only pure water as a byproduct.
                        </p>
                    </article>

                    <article>
                        <header><strong>Step 4: Precision Cold Storage</strong></header>
                        <p>
                            Our hydrogen-powered refrigeration maintains temperatures between
                            13°C and 14°C with precision control. This optimal range preserves
                            banana pectin, vitamins, and flavor from harvest to your table.
                        </p>
                    </article>
                </div>

                <blockquote>
                    <p>
                        "By harnessing the power of seawater electrolysis, we've reduced our
                        carbon footprint by 90% compared to traditional diesel-powered
                        refrigeration systems."
                    </p>
                    <footer>
                        <cite>— Dr. Otto Gunther Octavius, Chief Sustainability Officer</cite>
                    </footer>
                </blockquote>
            </section>

            <section>
                <h3>🍌 Health Benefits: The Power of Banana Pectin</h3>
                <p>
                    Beyond sustainable transport, we're passionate about the nutritional benefits
                    of bananas. All our varieties are rich in <strong>banana pectin</strong>—a
                    soluble fiber that provides remarkable digestive health benefits:
                </p>

                <ul>
                    <li><strong>Prebiotic Effect:</strong> Feeds beneficial gut bacteria, increasing Bifidobacteria populations by up to 40%</li>
                    <li><strong>Digestive Regulation:</strong> Forms a gel that regulates bowel movements and reduces inflammation</li>
                    <li><strong>Blood Sugar Control:</strong> Slows glucose absorption, helping maintain stable energy levels</li>
                    <li><strong>Satiety:</strong> Promotes feeling of fullness, supporting healthy weight management</li>
                    <li><strong>Resistant Starch:</strong> Green-tipped bananas contain resistant starch that produces beneficial short-chain fatty acids</li>
                </ul>

                <p>
                    Clinical studies show that consuming 15-20g of banana fiber daily can reduce
                    markers of digestive inflammation by up to 35% and provide relief for IBS sufferers.
                </p>
            </section>

            <section>
                <h3>🌍 Our Impact</h3>
                <div class="grid">
                    <div>
                        <h4>90%</h4>
                        <p>Reduction in CO₂ emissions</p>
                    </div>
                    <div>
                        <h4>10,000+</h4>
                        <p>Tons delivered via hydrogen power</p>
                    </div>
                    <div>
                        <h4>30+</h4>
                        <p>Exotic banana varieties sourced</p>
                    </div>
                    <div>
                        <h4>99.7%</h4>
                        <p>System uptime reliability</p>
                    </div>
                </div>
            </section>

            <section>
                <h3>🔬 Innovation Partners</h3>
                <p>
                    We collaborate with leading research institutions and technology providers
                    to continuously improve our systems. Our partnerships with HydroGen Technologies,
                    Stanford University, and the International Journal of Gastroenterology ensure
                    we remain at the forefront of both sustainable energy and nutritional science.
                </p>
            </section>

            <div class="banana-buoy-text-align-center">
                <a href="/banana-buoy/products/" role="button">Explore Our Products</a>
                <a href="/banana-buoy/news/" role="button" class="secondary">Read Latest Research</a>
            </div>
        </article>
        <?php
    }
}

