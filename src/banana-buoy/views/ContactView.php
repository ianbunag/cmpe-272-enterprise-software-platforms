<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseView.php';

class ContactView extends BaseView
{
    public function __construct()
    {
        $this->pageTitle = 'Contact - Banana Buoy';
        parent::__construct();
    }

    /**
     * @param array $data Array containing contact information
     *                    - contactEmail (string): Primary contact email address
     *                    - submitted (bool): Whether form was submitted successfully
     */
    protected function renderContent(array $data = []): void
    {
        $contactEmail = $data['contactEmail'] ?? '';
        $submitted = $data['submitted'] ?? false;
        ?>
        <?php if ($submitted): ?>
            <div class="banana-buoy-alert-info">
                <strong>Thank you!</strong> We've received your message and will respond shortly.
            </div>
        <?php endif; ?>

        <article>
            <section>
                <hgroup>
                    <h1>Contact Us</h1>
                    <h2>Get in Touch with Banana Buoy</h2>
                </hgroup>

                <img src="../../static/banana-buoy/hero-contact.webp?version=<?= $this->version ?>"
                     alt="Professional contact illustration showing communication and customer support"
                     class="banana-buoy-image-hero-landscape">
            </section>

            <section>
                <h3>📧 Email Us</h3>
                <p>
                    For inquiries about our products, sustainable technology, or partnership
                    opportunities, please reach out to:
                </p>
                <p>
                    <strong>
                        <a href="mailto:<?= htmlspecialchars($contactEmail) ?>">
                            <?= htmlspecialchars($contactEmail) ?>
                        </a>
                    </strong>
                </p>
            </section>

            <section>
                <h3>📬 Send Us a Message</h3>
                <form method="POST" action="/banana-buoy/contact/">
                    <label for="name">
                        Name
                        <input type="text" id="name" name="name" placeholder="Your name" required>
                    </label>

                    <label for="email">
                        Email
                        <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
                    </label>

                    <label for="subject">
                        Subject
                        <select id="subject" name="subject" required>
                            <option value="">Select a topic...</option>
                            <option value="products">Product Inquiry</option>
                            <option value="wholesale">Wholesale/Partnership</option>
                            <option value="technology">Hydrogen Technology</option>
                            <option value="nutrition">Nutrition Information</option>
                            <option value="other">Other</option>
                        </select>
                    </label>

                    <label for="message">
                        Message
                        <textarea id="message" name="message" rows="6" placeholder="Your message..." required></textarea>
                    </label>

                    <button type="submit">Send Message</button>
                </form>
            </section>

            <section>
                <h3>🏢 Visit Us</h3>
                <div class="grid">
                    <div>
                        <h4>Headquarters</h4>
                        <p>
                            One Washington Square<br>
                            San José, CA 95192<br>
                            United States
                        </p>
                    </div>
                    <div>
                        <h4>Research Facility</h4>
                        <p>
                            One Washington Square<br>
                            San José, CA 95192<br>
                            United States
                        </p>
                    </div>
                </div>
            </section>

            <section>
                <h3>⏰ Business Hours</h3>
                <p>
                    Monday - Friday: 8:00 AM - 6:00 PM PST<br>
                    Saturday: 9:00 AM - 3:00 PM PST<br>
                    Sunday: Closed
                </p>
            </section>
        </article>
        <?php
    }
}

