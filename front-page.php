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
        $hero_img = get_stylesheet_directory_uri() . '/images/hero-bg.png';
        ?>
        <section class="hero-section" style="background-image: url('<?php echo esc_url( $hero_img ); ?>')">
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
                        // Obtener categorías reales de WooCommerce, excluyendo "Uncategorized"
                        $product_categories = get_terms( array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => true,           // solo categorías con productos
                            'orderby'    => 'menu_order',   // respeta el orden configurado en WP
                            'order'      => 'ASC',
                            'exclude'    => array( get_option( 'default_product_cat' ) ), // excluye "Uncategorized"
                        ) );

                        if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) :
                            foreach ( $product_categories as $cat ) :
                                $cat_url       = get_term_link( $cat );
                                $thumbnail_id  = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                                $img_src       = $thumbnail_id
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
                                        <!-- Placeholder si la categoría no tiene imagen asignada -->
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

        <!-- ================ WHAT'S NEW + TRENDING ================ -->
        <section class="trending-section">
            <div class="trending-container">
                <h2 class="trending-title">What's New + Trending?</h2>
                <div class="trending-grid">
                    <div class="trending-item trending-left">
                        <div class="trending-img-wrap">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/trending-editorial.png" alt="The Men's Edit" class="trending-img" style="object-position: left center;">
                        </div>
                        <div class="trending-info">
                            <p class="trending-label">THE MEN'S EDIT</p>
                            <p class="trending-desc">Curated pieces for him, foolproof gifting for you. Thank us later.</p>
                            <a href="<?php echo esc_url( $shop_url ); ?>" class="trending-shop-link">SHOP NOW</a>
                        </div>
                    </div>
                    <div class="trending-item trending-right">
                        <div class="trending-img-wrap">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/trending-editorial.png" alt="New Arrivals" class="trending-img" style="object-position: right center;">
                        </div>
                        <div class="trending-info">
                            <p class="trending-label">NEW ARRIVALS</p>
                            <p class="trending-desc">She stole the show, now steal her style. Shop our latest curated edit.</p>
                            <a href="<?php echo esc_url( $shop_url ); ?>" class="trending-shop-link">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
                                    <p class="rec-card-material">18k Gold Vermeil</p>
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
                            // Fallback cards when no WooCommerce products
                            $fallback_items = array(
                                array('title' => 'Heart Station Chain Bracelet', 'price' => '$110'),
                                array('title' => 'Heart Chain Necklace',         'price' => '$149'),
                                array('title' => 'Siren Muse Mini Huggie Earrings','price' => '$70'),
                                array('title' => 'February Birthstone Necklace', 'price' => '$149'),
                                array('title' => 'February Birthstone Bracelet', 'price' => '$130'),
                                array('title' => 'Gemstone Mini Huggie Earrings','price' => '$105'),
                            );
                            foreach ( $fallback_items as $idx => $item ) :
                        ?>
                        <div class="rec-card">
                            <?php if ( $idx < 3 ) : ?>
                            <span class="rec-badge">Bestseller</span>
                            <?php endif; ?>
                            <div class="rec-card-link">
                                <div class="rec-img-placeholder"></div>
                                <div class="rec-card-info">
                                    <p class="rec-card-material">18k Gold Vermeil</p>
                                    <h3 class="rec-card-title"><?php echo esc_html($item['title']); ?></h3>
                                    <p class="rec-card-price"><?php echo esc_html($item['price']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================ AS SEEN ON ================ -->
        <section class="as-seen-section">
            <div class="as-seen-container">
                <h2 class="as-seen-title"><em>As Seen On MV</em></h2>
                <div class="as-seen-slider-wrapper">
                    <button class="as-seen-nav as-seen-prev" aria-label="Previous">&larr;</button>
                    <div class="as-seen-track-outer">
                        <div class="as-seen-track" id="asSeenTrack">
                            <div class="as-seen-slide">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/as-seen-on.png" alt="As Seen On MV - 1" class="as-seen-img" style="object-position: 0% center;">
                            </div>
                            <div class="as-seen-slide">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/as-seen-on.png" alt="As Seen On MV - 2" class="as-seen-img" style="object-position: 33.3% center;">
                            </div>
                            <div class="as-seen-slide">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/as-seen-on.png" alt="As Seen On MV - 3" class="as-seen-img" style="object-position: 66.6% center;">
                            </div>
                            <div class="as-seen-slide">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/as-seen-on.png" alt="As Seen On MV - 4" class="as-seen-img" style="object-position: 83.3% center;">
                            </div>
                            <div class="as-seen-slide">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/as-seen-on.png" alt="As Seen On MV - 5" class="as-seen-img" style="object-position: 100% center;">
                            </div>
                        </div>
                    </div>
                    <button class="as-seen-nav as-seen-next" aria-label="Next">&rarr;</button>
                </div>
                <div class="as-seen-dots">
                    <span class="as-dot"></span>
                    <span class="as-dot"></span>
                    <span class="as-dot active"></span>
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
    var catTrack    = document.getElementById('categoryTrack');
    var catPrev     = document.querySelector('.cat-prev');
    var catNext     = document.querySelector('.cat-next');
    var catCardW    = 0;
    var catOffset   = 0;
    var catVisible  = 5;

    function getCatCardW() {
        var card = catTrack && catTrack.querySelector('.category-card');
        return card ? card.offsetWidth + 24 : 220; // gap 24
    }
    function updateCat() {
        catTrack.style.transform = 'translateX(' + (-catOffset) + 'px)';
    }
    if (catPrev && catNext && catTrack) {
        catPrev.addEventListener('click', function() {
            catCardW = getCatCardW();
            catOffset = Math.max(0, catOffset - catCardW);
            updateCat();
        });
        catNext.addEventListener('click', function() {
            catCardW = getCatCardW();
            var maxOffset = Math.max(0, catTrack.scrollWidth - catTrack.parentElement.offsetWidth);
            catOffset = Math.min(maxOffset, catOffset + catCardW);
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

    // As Seen On slider
    var asTrack  = document.getElementById('asSeenTrack');
    var asPrev   = document.querySelector('.as-seen-prev');
    var asNext   = document.querySelector('.as-seen-next');
    var asDots   = document.querySelectorAll('.as-dot');
    var asOffset = 0;
    var asIndex  = 0;

    function getAsSlideW() {
        var slide = asTrack && asTrack.querySelector('.as-seen-slide');
        return slide ? slide.offsetWidth + 8 : 300;
    }
    function updateAs() {
        asTrack.style.transform = 'translateX(' + (-asOffset) + 'px)';
        asDots.forEach(function(d, i) {
            d.classList.toggle('active', i === (asIndex % 3));
        });
    }
    if (asPrev && asNext && asTrack) {
        asPrev.addEventListener('click', function() {
            var w = getAsSlideW();
            asOffset = Math.max(0, asOffset - w);
            asIndex = Math.max(0, asIndex - 1);
            updateAs();
        });
        asNext.addEventListener('click', function() {
            var w = getAsSlideW();
            var maxOffset = Math.max(0, asTrack.scrollWidth - asTrack.parentElement.offsetWidth);
            asOffset = Math.min(maxOffset, asOffset + w);
            asIndex++;
            updateAs();
        });
    }
})();
</script>

<?php get_footer(); ?>