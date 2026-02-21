<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBananaBuoyTables extends AbstractMigration
{
    /**
     * Create the products and news tables with seed data
     */
    public function change(): void
    {
        // Create products table
        $products = $this->table('products');
        $products->addColumn('name', 'string', ['limit' => 100])
                 ->addColumn('origin_country', 'string', ['limit' => 100])
                 ->addColumn('taste_profile', 'text')
                 ->addColumn('image_url', 'string', ['limit' => 255, 'null' => true])
                 ->addColumn('alt_text', 'string', ['limit' => 255])
                 ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2])
                 ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                 ->create();

        // Create news table
        $news = $this->table('news');
        $news->addColumn('title', 'string', ['limit' => 200])
             ->addColumn('content', 'text')
             ->addColumn('date_published', 'date')
             ->addColumn('image_url', 'string', ['limit' => 255, 'null' => true])
             ->addColumn('alt_text', 'string', ['limit' => 255])
             ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
             ->create();

        // Seed 30 banana products
        $this->execute("
            INSERT INTO products (name, origin_country, taste_profile, image_url, alt_text, price) VALUES
            ('Blue Java', 'Hawaii', 'Creamy vanilla ice cream flavor with a smooth, sweet finish', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Blue Java banana with distinctive blue-silver peel', 4.99),
            ('Red Dacca', 'India', 'Rich and sweet with berry undertones and soft texture', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Red Dacca banana with deep maroon colored skin', 5.49),
            ('Saba', 'Philippines', 'Starchy and slightly tangy, perfect for cooking', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Saba cooking banana with angular shape', 3.99),
            ('Lady Finger', 'Australia', 'Exceptionally sweet and creamy with delicate texture', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Small Lady Finger bananas in a bunch', 6.99),
            ('Manzano', 'Mexico', 'Apple-strawberry flavor with hints of honey', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Chubby Manzano apple bananas with yellow skin', 5.99),
            ('Burro', 'Mexico', 'Tangy lemon flavor when unripe, sweet when ripe', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Square-shaped Burro bananas', 4.49),
            ('Cavendish', 'Ecuador', 'Classic sweet banana flavor, perfectly balanced', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Traditional Cavendish bananas in a bunch', 2.99),
            ('Pisang Raja', 'Indonesia', 'Honey-sweet with rich, dense texture', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Golden Pisang Raja King bananas', 7.49),
            ('Goldfinger', 'Honduras', 'Crisp apple-like texture with sweet flavor', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Goldfinger bananas with distinctive shape', 5.79),
            ('Gros Michel', 'Thailand', 'Traditional banana flavor, creamier than Cavendish', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Large Gros Michel Big Mike bananas', 6.49),
            ('Plantain', 'Colombia', 'Starchy and savory, ideal for frying', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Green plantains ready for cooking', 3.49),
            ('Lakatan', 'Philippines', 'Orange-fleshed with sweet tangy flavor', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Lakatan bananas with orange-tinted flesh', 5.29),
            ('Mysore', 'India', 'Mild sweet flavor with hint of tartness', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Mysore bananas with thin yellow skin', 4.79),
            ('Nanjangud', 'India', 'Aromatic with complex sweet flavor profile', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Premium Nanjangud GI tagged bananas', 8.99),
            ('Praying Hands', 'Indonesia', 'Sweet and creamy with unique fused fingers', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Rare Praying Hands bananas fused together', 12.99),
            ('Red Spanish', 'Cuba', 'Sweet with raspberry hints and pink flesh', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Red Spanish bananas with reddish-purple peel', 6.99),
            ('Matoke', 'Uganda', 'Green cooking banana, starchy and mild', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Matoke green cooking bananas', 3.99),
            ('Grand Nain', 'Costa Rica', 'Similar to Cavendish, slightly sweeter', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Grand Nain bananas premium quality', 3.49),
            ('Williams', 'Australia', 'Bright yellow with classic sweet taste', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Williams hybrid bananas', 3.99),
            ('Dwarf Cavendish', 'Canary Islands', 'Compact variety with intense sweetness', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Small Dwarf Cavendish bananas', 4.99),
            ('Fehi', 'Polynesia', 'Orange flesh, used for cooking, vitamin A rich', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Fehi cooking bananas with orange interior', 7.99),
            ('Cardaba', 'Philippines', 'Dense and starchy, perfect for banana cue', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Cardaba cooking bananas angular shape', 3.79),
            ('Ney Poovan', 'India', 'Aromatic small banana with intense flavor', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Ney Poovan baby bananas premium', 6.49),
            ('Barangan', 'Malaysia', 'Yellow-orange flesh, sweet and fragrant', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Barangan bananas Malaysian variety', 5.99),
            ('Bluggoe', 'Americas', 'Silver-bluish peel, tangy cooking variety', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Bluggoe silver bananas for cooking', 4.29),
            ('Ice Cream', 'Philippines', 'Blue Java type with vanilla custard taste', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Ice Cream bananas with blue-tinged peel', 7.99),
            ('Thousand Fingers', 'Africa', 'Numerous small fingers, sweet when ripe', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Thousand Fingers banana bunch with many fruits', 9.99),
            ('Señorita', 'Philippines', 'Tiny sweet bananas, rich flavor', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Señorita miniature bananas', 5.49),
            ('Rhino Horn', 'Africa', 'Extremely long banana, mild sweet flavor', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Rhino Horn banana extraordinarily long', 11.99),
            ('Kandrian', 'Papua New Guinea', 'Rare heritage variety, complex flavor', 'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/products/banana.jpeg', 'Kandrian heritage bananas rare variety', 13.99)
        ");

        // Seed 10 news stories about Hydrogen PEM Electrolysis and Banana Pectin
        $this->execute("
            INSERT INTO news (title, content, date_published, image_url, alt_text) VALUES
            (
                'Revolutionary Hydrogen-Powered Refrigeration Goes Live',
                'Banana Buoy announces the successful deployment of seawater hydrogen electrolysis systems across our entire fleet. Using Proton Exchange Membrane (PEM) electrolysis, we split seawater into hydrogen and oxygen, with the hydrogen fueling our refrigeration units. This breakthrough reduces our carbon footprint by 90% compared to traditional diesel-powered systems. The PEM technology operates efficiently even with renewable energy sources, making our banana transport truly sustainable. Our first hydrogen-powered vessel completed a 5,000-mile journey maintaining perfect temperature control at -2°C to 14°C range.',
                '2026-02-15',
                'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/news/banana.jpeg',
                'Hydrogen PEM electrolysis system on banana transport vessel'
            ),
            (
                'The Science Behind Banana Pectin: Digestive Health Benefits',
                'Recent studies confirm what we have always known: bananas are fiber powerhouses. Banana pectin, a type of soluble fiber, acts as a prebiotic feeding beneficial gut bacteria. Research published in the Journal of Nutritional Science shows that consuming two bananas daily increases Bifidobacteria populations by 40%. Pectin also forms a gel in the digestive tract, slowing glucose absorption and promoting satiety. Our banana varieties, particularly the Gros Michel and Pisang Raja, contain up to 3.5g of pectin per fruit. The resistant starch in slightly green bananas further enhances digestive health by producing short-chain fatty acids.',
                '2026-02-12',
                'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/news/banana.jpeg',
                'Microscopic view of banana pectin fiber structure'
            ),
            (
                'Seawater Electrolysis: Converting Ocean Water to Clean Energy',
                'How do we power our refrigeration with seawater? Our PEM electrolysis units desalinate and purify seawater, then apply electrical current to split H2O molecules. The cathode produces pure hydrogen gas, while the anode releases oxygen. The proton exchange membrane ensures only hydrogen ions pass through, creating 99.999% pure hydrogen. This hydrogen is compressed and stored in carbon-fiber tanks, then fed to fuel cells that generate electricity for our cooling systems. The only byproduct is pure drinking water. Each vessel produces 500 kg of hydrogen per day, enough to maintain refrigeration for 15,000 bananas.',
                '2026-02-10',
                'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/news/banana.jpeg',
                'Diagram of PEM electrolysis process converting seawater to hydrogen'
            ),
            (
                'Clinical Trial: Banana Fiber Reduces Digestive Inflammation',
                'A groundbreaking 12-week clinical trial at Stanford University revealed that banana pectin significantly reduces markers of digestive inflammation. Participants consuming 20g of banana fiber daily showed a 35% reduction in C-reactive protein (CRP) and a 28% decrease in intestinal permeability. The pectin acts as a protective barrier against pathogens while nourishing beneficial bacteria. Dr. Sarah Chen, lead researcher, states: \"Banana pectin demonstrates remarkable anti-inflammatory properties comparable to pharmaceutical interventions, but without side effects.\" Our Red Dacca and Lakatan varieties showed the highest pectin concentrations in the study.',
                '2026-02-08',
                'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/news/banana.jpeg',
                'Researchers analyzing banana fiber samples in laboratory'
            ),
            (
                'Zero-Emission Fleet Milestone: 10,000 Tons of Bananas Delivered',
                'Banana Buoy celebrates delivering 10,000 tons of bananas using exclusively hydrogen-powered refrigeration. This milestone represents a displacement of 2,500 tons of CO2 emissions compared to conventional transport. Our PEM electrolysis systems have operated continuously for 180 days with 99.7% uptime. The hydrogen production cost has decreased to $3.50 per kilogram, making it economically competitive with diesel. Investment in renewable energy integration means 75% of our electrolysis power now comes from solar panels and wind turbines mounted on our vessels.',
                '2026-02-05',
                'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/news/banana.jpeg',
                'Banana Buoy hydrogen-powered vessel at port with banner celebrating 10000 tons'
            ),
            (
                'Banana Pectin: Natural Solution for Irritable Bowel Syndrome',
                'New research from the International Journal of Gastroenterology demonstrates that banana pectin provides relief for IBS sufferers. The soluble fiber regulates bowel movements, absorbs excess water in diarrhea cases, and softens stool in constipation cases. A study of 200 IBS patients showed 65% symptom improvement after 8 weeks of consuming 15g banana pectin daily. The pectin fermentation produces butyrate, a compound that strengthens the intestinal lining. Green-tipped bananas contain higher resistant starch levels, offering additional benefits. Our Burro and Saba varieties are recommended for therapeutic use.',
                '2026-02-03',
                'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/news/banana.jpeg',
                'Infographic showing banana pectin benefits for digestive health'
            ),
            (
                'Next-Generation PEM Technology Increases Hydrogen Efficiency 40%',
                'Banana Buoy partners with HydroGen Technologies to deploy third-generation PEM electrolyzers. These advanced systems use nano-structured catalysts that reduce energy consumption from 55 kWh/kg to 39 kWh/kg of hydrogen produced. The improved membrane durability extends service life to 100,000 hours. Dynamic load management allows our systems to ramp from 10% to 100% capacity in under 2 seconds, perfectly matching solar and wind power fluctuations. Real-time monitoring via IoT sensors optimizes seawater intake, temperature control, and gas purity. Installation across our fleet begins this month.',
                '2026-01-30',
                'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/news/banana.jpeg',
                'Technician installing advanced PEM electrolyzer with nano-catalyst membrane'
            ),
            (
                'Resistant Starch in Bananas: The Forgotten Fiber Powerhouse',
                'While banana pectin gets attention, resistant starch deserves equal recognition. This fiber type resists digestion in the small intestine, reaching the colon intact where it feeds beneficial bacteria. Research shows resistant starch improves insulin sensitivity, lowers blood glucose spikes, and increases fat oxidation. Green bananas contain up to 20g resistant starch per 100g, while ripe bananas have just 1g. Our Plantain and Matoke cooking varieties are particularly rich sources. When cooled after cooking, resistant starch content increases further through retrogradation, making banana-based dishes even healthier.',
                '2026-01-25',
                'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/news/banana.jpeg',
                'Chart comparing resistant starch levels in green versus ripe bananas'
            ),
            (
                'Hydrogen Safety Systems: Engineering Trust in Marine Transport',
                'Safety is paramount in hydrogen operations. Our vessels feature triple-redundant gas detection systems monitoring for leaks at 0.1% concentration thresholds. Hydrogen storage tanks are tested to 10x operating pressure and positioned in ventilated compartments with automatic fire suppression. The PEM electrolyzers include pressure relief valves, emergency shutdown systems, and grounding protection. All crew complete 40-hour hydrogen safety certification. In 18 months of operation, we have had zero incidents. Hydrogen disperses rapidly being 14x lighter than air, making it safer than gasoline or diesel in open-air scenarios.',
                '2026-01-20',
                'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/news/banana.jpeg',
                'Engineer inspecting hydrogen safety monitoring system on vessel'
            ),
            (
                'Farm to Table: How Hydrogen Refrigeration Preserves Banana Nutrition',
                'Temperature control is critical for preserving banana nutrients. Our hydrogen-powered refrigeration maintains precise 13°C for optimal pectin retention. Studies show traditional cold chains with temperature fluctuations degrade pectin content by up to 30%. Our PEM-powered systems provide stable, continuous cooling from harvest to delivery. Vitamin C levels remain 95% intact versus 70% in conventional transport. The controlled atmosphere regulation prevents ethylene buildup, slowing ripening while preserving antioxidant levels. Firmness, color, and taste profile are maintained at harvest-day quality. This means more nutrition and better flavor for consumers.',
                '2026-01-15',
                'https://storage.googleapis.com/cmpe-272.ianbunag.dev/banana-buoy/news/banana.jpeg',
                'Temperature monitoring display showing stable 13 degrees Celsius in refrigerated banana container'
            )
        ");
    }
}

