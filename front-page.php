<?php
/**
 * Template: Página de Inicio (Front Page)
 * Child Theme Override — Astra Child / Ecommerce Xavier
 *
 * @package Astra Child
 */

get_header();
?>

<div id="primary" class="content-area child-front-page">
    <main id="main" class="site-main home-main" role="main">

        <!-- ===================== HERO ===================== -->
        <?php
        $shop_url = function_exists( 'wc_get_page_id' )
            ? get_permalink( wc_get_page_id( 'shop' ) )
            : home_url( '/shop/' );
        ?>
        <section class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>The Charm Shop is <em>open</em>.<br>Stack accordingly.</h1>
                    <div class="hero-buttons">
                        <a href="<?php echo esc_url( $shop_url ); ?>" class="btn btn-primary">SHOP ALL CHARMS</a>
                        <a href="<?php echo esc_url( $shop_url ); ?>?filter=category" class="btn btn-secondary">SHOP BY CATEGORY</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================ SHOP BY CATEGORY ================ -->
        <section class="category-section">
            <div class="category-container">
                <div class="category-header">
                    <h2>Shop by Category</h2>
                    <div class="category-nav">
                        <button class="cat-nav-btn cat-prev" aria-label="Previous">&larr;</button>
                        <button class="cat-nav-btn cat-next" aria-label="Next">&rarr;</button>
                    </div>
                </div>

                <div class="category-track-wrapper">
                    <div class="category-track" id="categoryTrack">
                        <?php
                        $product_categories = get_terms( array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => true,
                            'orderby'    => 'menu_order',
                            'order'      => 'ASC',
                            'exclude'    => array( get_option( 'default_product_cat' ) ),
                        ) );

                        if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) :
                            foreach ( $product_categories as $cat ) :
                                $cat_url      = get_term_link( $cat );
                                $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                                $img_src      = $thumbnail_id
                                    ? wp_get_attachment_image_url( $thumbnail_id, 'medium' )
                                    : '';
                        ?>
                        <div class="category-card">
                            <a href="<?php echo esc_url( $cat_url ); ?>" class="category-card-link">
                                <div class="category-img-wrap">
                                    <?php if ( $img_src ) : ?>
                                        <img
                                            src="<?php echo esc_url( $img_src ); ?>"
                                            alt="<?php echo esc_attr( $cat->name ); ?>"
                                            class="category-img"
                                            loading="lazy"
                                        >
                                    <?php else : ?>
                                        <div class="category-img-placeholder">
                                            <span><?php echo esc_html( $cat->name[0] ); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p class="category-label"><?php echo esc_html( strtoupper( $cat->name ) ); ?></p>
                            </a>
                        </div>
                        <?php
                            endforeach;
                        else :
                            echo '<p class="no-categories">No hay categorías disponibles todavía.</p>';
                        endif;
                        ?>
                    </div>
                </div>

                <div class="category-shopall">
                    <a href="<?php echo esc_url( $shop_url ); ?>" class="btn-shopall">SHOP ALL &rarr;</a>
                </div>
            </div>
        </section>

        <!-- ================ TRENDING PRODUCTS ================ -->
        <?php
        $trending_cat  = get_term_by( 'slug', 'trending', 'product_cat' );
        $trending_args = array(
            'post_type'      => 'product',
            'posts_per_page' => 2,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        if ( $trending_cat && ! is_wp_error( $trending_cat ) ) {
            $trending_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => 'trending',
                ),
            );
            $section_title = 'Trending';
        } else {
            $section_title = 'Lo Más Nuevo';
        }
        $trending_query = new WP_Query( $trending_args );
        ?>
        <?php if ( $trending_query->have_posts() ) : ?>
        <section class="trending-section">
            <div class="trending-container">
                <h2 class="trending-title"><?php echo esc_html( $section_title ); ?></h2>
                <div class="trending-grid">
                    <?php while ( $trending_query->have_posts() ) : $trending_query->the_post();
                        global $product;
                        if ( ! $product ) $product = wc_get_product( get_the_ID() );
                        $short_desc = $product ? $product->get_short_description() : get_the_excerpt();
                        $short_desc = wp_strip_all_tags( $short_desc );
                        if ( strlen( $short_desc ) > 120 ) {
                            $short_desc = substr( $short_desc, 0, 120 ) . '…';
                        }
                    ?>
                    <div class="trending-card">
                        <a href="<?php the_permalink(); ?>" class="trending-card-link">
                            <div class="trending-img-wrap">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'large', array( 'class' => 'trending-img' ) ); ?>
                                <?php else : ?>
                                    <div class="trending-img-placeholder"></div>
                                <?php endif; ?>
                            </div>
                        </a>
                        <div class="trending-info">
                            <p class="trending-label"><?php the_title(); ?></p>
                            <?php if ( $short_desc ) : ?>
                            <p class="trending-desc"><?php echo esc_html( $short_desc ); ?></p>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>" class="btn-comprar">Comprar ahora</a>
                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ================ WE THINK YOU MAY LIKE ================ -->
        <section class="recommended-section">
            <div class="recommended-container">
                <div class="recommended-header">
                    <h2>We think you may like&hellip;</h2>
                    <div class="rec-nav">
                        <button class="rec-nav-btn rec-prev" aria-label="Previous">&larr;</button>
                        <button class="rec-nav-btn rec-next" aria-label="Next">&rarr;</button>
                    </div>
                </div>

                <div class="rec-track-wrapper">
                    <div class="rec-track" id="recTrack">
                        <?php
                        $rec_query = new WP_Query( array(
                            'post_type'      => 'product',
                            'posts_per_page' => 8,
                            'orderby'        => 'popularity',
                            'order'          => 'DESC',
                        ) );

                        if ( $rec_query->have_posts() ) :
                            while ( $rec_query->have_posts() ) :
                                $rec_query->the_post();
                                global $product;
                                if ( ! $product ) $product = wc_get_product( get_the_ID() );
                                $is_bestseller = $product && $product->is_featured();
                                $price = $product ? $product->get_price_html() : '';
                        ?>
                        <div class="rec-card">
                            <?php if ( $is_bestseller ) : ?>
                            <span class="rec-badge">Bestseller</span>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>" class="rec-card-link">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium', array( 'class' => 'rec-img' ) ); ?>
                                <?php else : ?>
                                    <div class="rec-img-placeholder"></div>
                                <?php endif; ?>
                                <div class="rec-card-info">
                                    <h3 class="rec-card-title"><?php the_title(); ?></h3>
                                    <?php if ( $price ) : ?>
                                    <p class="rec-card-price"><?php echo $price; ?></p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p style="color:#999;font-family:\'Jost\',sans-serif;font-size:14px;">Agrega productos a tu tienda para verlos aquí.</p>';
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================ AS SEEN ON ================ -->
        <section class="as-seen-section">
            <div class="as-seen-container">
                <h2 class="as-seen-title"><em>As Seen On MV</em></h2>
                <div class="as-seen-placeholder">
                    <p>Próximamente — agrega imágenes a esta sección.</p>
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
                    We'll update you by email &amp; SMS and you can unsubscribe at any time &mdash; <a href="#">Privacy Policy</a>
                </p>
            </div>
        </section>

    </main><!-- #main -->
</div><!-- #primary -->

<script>
(function() {
    // Category carousel
    var catTrack   = document.getElementById('categoryTrack');
    var catPrev    = document.querySelector('.cat-prev');
    var catNext    = document.querySelector('.cat-next');
    var catOffset  = 0;

    function getCatCardW() {
        var card = catTrack && catTrack.querySelector('.category-card');
        return card ? card.offsetWidth + 24 : 220;
    }
    function updateCat() {
        catTrack.style.transform = 'translateX(' + (-catOffset) + 'px)';
    }
    if (catPrev && catNext && catTrack) {
        catPrev.addEventListener('click', function() {
            catOffset = Math.max(0, catOffset - getCatCardW());
            updateCat();
        });
        catNext.addEventListener('click', function() {
            var maxOffset = Math.max(0, catTrack.scrollWidth - catTrack.parentElement.offsetWidth);
            catOffset = Math.min(maxOffset, catOffset + getCatCardW());
            updateCat();
        });
    }

    // Recommended carousel
    var recTrack  = document.getElementById('recTrack');
    var recPrev   = document.querySelector('.rec-prev');
    var recNext   = document.querySelector('.rec-next');
    var recOffset = 0;

    function getRecCardW() {
        var card = recTrack && recTrack.querySelector('.rec-card');
        return card ? card.offsetWidth + 20 : 240;
    }
    function updateRec() {
        recTrack.style.transform = 'translateX(' + (-recOffset) + 'px)';
    }
    if (recPrev && recNext && recTrack) {
        recPrev.addEventListener('click', function() {
            recOffset = Math.max(0, recOffset - getRecCardW());
            updateRec();
        });
        recNext.addEventListener('click', function() {
            var maxOffset = Math.max(0, recTrack.scrollWidth - recTrack.parentElement.offsetWidth);
            recOffset = Math.min(maxOffset, recOffset + getRecCardW());
            updateRec();
        });
    }
})();
</script>

<?php get_footer(); ?>