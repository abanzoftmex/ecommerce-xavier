<?php
/**
 * Footer personalizado para el child theme
 * 
 * GUIA RAPIDA PARA EDITAR EL PIE DE PAGINA:
 * - LINKS DE COLUMNAS (Ayuda, Empresa...): busca los bloques <div class="footer-section">
 * - REDES SOCIALES: busca la seccion class="footer-section" que dice REDES SOCIALES
 * - TELEFONO / EMAIL: busca la seccion class="footer-section" que dice Dudas o comentarios
 * - COPYRIGHT: busca la seccion class="footer-bottom" -> class="copyright"
 * - LOGO DEL FOOTER: busca <h2><?php bloginfo('name'); ?></h2>
 * 
 * @package Astra Child
 */
?>
    <footer id="colophon" class="site-footer">
        <div class="footer-content">
            <div class="footer-sections">
                
                <!-- ═══════════════════════════════════════════════════════════
                     SECCION DE AYUDA / LINKS
                     ═══════════════════════════════════════════════════════════
                     PARA CAMBIAR LOS LINKS: edita el href="#" por la URL
                     PARA CAMBIAR EL TEXTO: edita el texto dentro de <a> -->
                <div class="footer-section">
                    <h3>AYUDA</h3>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Guía de tallas</a></li>
                        <li><a href="#">Cuidado de joyas</a></li>
                        <li><a href="#">Reparaciones y garantía de por vida</a></li>
                    </ul>
                </div>

                <!-- Company Section -->
                <div class="footer-section">
                    <h3>EMPRESA</h3>
                    <ul>
                        <li><a href="#">Nuestra Historia</a></li>
                        <li><a href="#">Contacto</a></li>
                        <li><a href="#">Términos y condiciones</a></li>
                        <li><a href="#">Política de privacidad</a></li>
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
                        <span class="currency-code">MXN</span>
                    </div>

                    <!-- Payment Methods -->
                    <div class="payment-methods">
                        <span class="payment-icon">💳</span>
                        <span class="payment-icon">💰</span>
                        <span class="payment-icon">🏦</span>
                    </div>
                </div>

                <!-- Connect Section -->
                <div class="footer-section">
                    <h3>¿Dudas o comentarios?</h3>
                    <ul>
                        <li><a href="#">Tel: 123 456 7890</a></li>
                        <li><a href="#">info@info.com</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>

                <!-- ═══════════════════════════════════════════════════════════
                     SECCION DE REDES SOCIALES
                     ═══════════════════════════════════════════════════════════
                     PARA AGREGAR UNA RED: agrega un <li><a href="URL">Nombre</a></li>
                     Asegurate de cambiar el # por el link real de tu red social -->
                <div class="footer-section">
                    <h3>REDES SOCIALES</h3>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">Tik Tok</a></li>
                    </ul>
                </div>

            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="legal-links">
                    <a href="#">Términos y condiciones</a>
                    <a href="#">Política de privacidad</a>
                    <a href="#">Preferencias de cookies</a>
                </div>
                <div class="copyright">
                    <p>&copy; <?php echo bloginfo('name'); ?> Ltd <?php echo date('Y'); ?> - <?php echo date('Y', strtotime('+2 years')); ?>. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>