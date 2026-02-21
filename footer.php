    <footer id="colophon" class="site-footer">
        <div class="footer-content">
            <div class="footer-sections">
                
                <!-- Help Section -->
                <div class="footer-section">
                    <h3>HELP</h3>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Size Guide</a></li>
                        <li><a href="#">Delivery & Returns</a></li>
                        <li><a href="#">Jewelry Care</a></li>
                        <li><a href="#">Lifetime Repairs & Warranty</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Sitemap</a></li>
                        <li><a href="#">Recall Information</a></li>
                    </ul>
                </div>

                <!-- Company Section -->
                <div class="footer-section">
                    <h3>COMPANY</h3>
                    <ul>
                        <li><a href="#">Our Story</a></li>
                        <li><a href="#">Our Stores</a></li>
                        <li><a href="#">Sustainability</a></li>
                        <li><a href="#">Factories</a></li>
                        <li><a href="#">Materials</a></li>
                        <li><a href="#">Product Passport</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Policies</a></li>
                    </ul>
                </div>

                <!-- Brand Logo Section -->
                <div class="footer-section footer-brand">
                    <div class="brand-logo">
                        <h2><?php bloginfo('name'); ?></h2>
                    </div>
                    
                    <!-- Currency Selector -->
                    <div class="currency-selector">
                        <span class="currency-flag">🇲🇽</span>
                        <span class="currency-code">MX USD</span>
                    </div>

                    <!-- Payment Methods -->
                    <div class="payment-methods">
                        <img src="data:image/svg+xml;base64,..." alt="Visa" class="payment-icon">
                        <img src="data:image/svg+xml;base64,..." alt="Mastercard" class="payment-icon">
                        <img src="data:image/svg+xml;base64,..." alt="American Express" class="payment-icon">
                        <img src="data:image/svg+xml;base64,..." alt="PayPal" class="payment-icon">
                        <img src="data:image/svg+xml;base64,..." alt="Apple Pay" class="payment-icon">
                        <img src="data:image/svg+xml;base64,..." alt="Google Pay" class="payment-icon">
                    </div>
                </div>

                <!-- Connect Section -->
                <div class="footer-section">
                    <h3>CONNECT</h3>
                    <ul>
                        <li><a href="#">Affiliates</a></li>
                        <li><a href="#">MV x Klarna Creator</a></li>
                        <li><a href="#">Keyworkers</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>

                <!-- Social Section -->
                <div class="footer-section">
                    <h3>SOCIAL</h3>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">Pinterest</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Weibo</a></li>
                    </ul>
                </div>

            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="legal-links">
                    <a href="#">Terms & Conditions</a>
                    <a href="#">Privacy Notice</a>
                    <a href="#">Cookie Preferences</a>
                    <a href="#">Modern Slavery Statement</a>
                    <a href="#">Gender Pay Gap Report</a>
                </div>
                <div class="copyright">
                    <p>&copy; <?php echo bloginfo('name'); ?> Ltd <?php echo date('Y'); ?> - <?php echo date('Y', strtotime('+2 years')); ?>. Site by DSR.</p>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>