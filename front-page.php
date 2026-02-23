<?php
/**
 * Template: Página de Inicio (Front Page)
 * Child Theme Override — Astra Child / Ecommerce Xavier
 *
 * WordPress usa este archivo automáticamente como front-page
 * cuando está configurado en Ajustes > Lectura.
 *
 * @package Astra Child
 */

get_header();
?>

<div id="primary" class="content-area child-front-page">
    <main id="main" class="site-main home-main" role="main">

        <!-- ===================== HERO ===================== -->
        <section class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>The Charm Shop is open. Stack accordingly.</h1>
                    <div class="hero-buttons">
                        <?php
                        $shop_url = function_exists( 'wc_get_page_id' )
                            ? get_permalink( wc_get_page_id( 'shop' ) )
                            : home_url( '/shop/' );
                        ?>
                        <a href="<?php echo esc_url( $shop_url ); ?>" class="btn btn-primary">SHOP ALL CHARMS</a>
                        <a href="<?php echo esc_url( $shop_url ); ?>" class="btn btn-secondary">SHOP BY CATEGORY</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================ PRODUCTOS DESTACADOS ================ -->
        <section class="featured-products-section">
            <div class="container">
                <div class="section-header">
                    <h2>Featured Products</h2>
                    <p>Discover our most popular items</p>
                </div>

                <div class="products-grid">
                    <?php
                    $featured_query = new WP_Query( array(
                        'post_type'      => 'product',
                        'posts_per_page' => 8,
                        'meta_query'     => array(
                            array(
                                'key'     => '_featured',
                                'value'   => 'yes',
                                'compare' => '=',
                            ),
                        ),
                    ) );

                    if ( $featured_query->have_posts() ) :
                        if ( function_exists( 'woocommerce_product_loop_start' ) ) {
                            woocommerce_product_loop_start();
                        }
                        while ( $featured_query->have_posts() ) :
                            $featured_query->the_post();
                            if ( function_exists( 'wc_get_template_part' ) ) {
                                wc_get_template_part( 'content', 'product' );
                            }
                        endwhile;
                        if ( function_exists( 'woocommerce_product_loop_end' ) ) {
                            woocommerce_product_loop_end();
                        }
                        wp_reset_postdata();
                    else :
                        echo '<p class="no-products">No featured products found.</p>';
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- ================== NEWSLETTER ================== -->
        <section class="newsletter-section">
            <div class="newsletter-content">
                <h2>Join MV Circle for early sale access, birthday treats, a discount on your first order, and more.</h2>
                <form class="newsletter-form" id="newsletter-signup-form">
                    <?php wp_nonce_field( 'newsletter_nonce', 'newsletter_nonce_field' ); ?>
                    <input type="email" placeholder="Email Address" class="email-input" required>
                    <button type="submit" class="btn btn-newsletter">JOIN NOW &rarr;</button>
                </form>
                <p class="newsletter-disclaimer">
                    We'll update you by email &amp; SMS and you can unsubscribe at any time &mdash; Privacy Policy
                </p>
            </div>
        </section>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>