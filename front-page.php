<?php
/**
 * Template para la página principal (home)
 * CHILD THEME OVERRIDE - No usar template de Astra/Elementor
 * 
 * @package Astra Child
 */

// Asegurarse de que Elementor no sobreescriba este template
define( 'ELEMENTOR_DISABLE_TYPOGRAPHY_SCHEMES', true );

get_header(); ?>


<div id="primary" class="content-area">
    <main id="main" class="site-main home-main" role="main">
        
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>The Charm Shop is open. Stack accordingly.</h1>
                    <div class="hero-buttons">
                        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-primary">SHOP ALL CHARMS</a>
                        <a href="#" class="btn btn-secondary">SHOP BY CATEGORY</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products Section -->
        <section class="featured-products-section">
            <div class="container">
                <div class="section-header">
                    <h2>Featured Products</h2>
                    <p>Discover our most popular items</p>
                </div>
                
                <div class="products-grid">
                    <?php
                    // Mostrar productos destacados
                    $featured_query = new WP_Query(array(
                        'post_type' => 'product',
                        'meta_key' => '_featured',
                        'meta_value' => 'yes',
                        'posts_per_page' => 8
                    ));
                    
                    if ($featured_query->have_posts()) :
                        woocommerce_product_loop_start();
                        while ($featured_query->have_posts()) :
                            $featured_query->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        woocommerce_product_loop_end();
                        wp_reset_postdata();
                    else :
                        echo '<p>No featured products found.</p>';
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Newsletter Section -->
        <section class="newsletter-section">
            <div class="newsletter-content">
                <h2>Join MV Circle for early sale access, birthday treats, a discount on your first order, and more.</h2>
                <form class="newsletter-form">
                    <input type="email" placeholder="Email Address" class="email-input">
                    <button type="submit" class="btn btn-newsletter">JOIN NOW →</button>
                </form>
                <p class="newsletter-disclaimer">
                    We'll update you by email + SMS and you can unsubscribe at any time - Privacy Policy
                </p>
            </div>
        </section>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>