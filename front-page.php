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
            <canvas id="heroParticles" class="hero-particles-canvas"></canvas>
            <div class="hero-content" style="position:relative;z-index:10;display:block;visibility:visible;opacity:1;padding:80px;max-width:480px;">
                <div class="hero-text">
                    <h1 style="color:#1a1a1a;font-family:'Cormorant Garamond',Georgia,serif;font-size:48px;font-weight:300;line-height:1.15;margin-bottom:36px;visibility:visible;opacity:1;display:block;-webkit-text-fill-color:#1a1a1a;">The Charm Shop is <em style="font-style:italic;color:#1a1a1a;-webkit-text-fill-color:#1a1a1a;">open</em>.<br>Stack accordingly.</h1>
                    <div class="hero-buttons" style="display:flex;gap:16px;flex-wrap:wrap;">
                        <a href="<?php echo esc_url( $shop_url ); ?>" class="btn btn-primary" style="display:inline-block;padding:12px 24px;background:#1a1a1a;color:#fff;border:1.5px solid #1a1a1a;font-family:'Jost',sans-serif;font-size:12px;font-weight:500;text-transform:uppercase;letter-spacing:1.2px;text-decoration:none;border-radius:0;-webkit-text-fill-color:#fff;">SHOP ALL CHARMS</a>
                        <a href="<?php echo esc_url( $shop_url ); ?>?filter=category" class="btn btn-secondary" style="display:inline-block;padding:12px 24px;background:transparent;color:#1a1a1a;border:1.5px solid #1a1a1a;font-family:'Jost',sans-serif;font-size:12px;font-weight:500;text-transform:uppercase;letter-spacing:1.2px;text-decoration:none;border-radius:0;-webkit-text-fill-color:#1a1a1a;">SHOP BY CATEGORY</a>
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

        <!-- ================ TRUST BADGES ================ -->
        <section class="trust-section">
            <div class="trust-container">
                <div class="trust-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:48px 80px;">

                    <div class="trust-item" style="display:flex;flex-direction:column;align-items:center;text-align:center;">
                        <div class="trust-icon">
                            <!-- Warranty / Medal -->
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" stroke="#1a1a1a" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="20" cy="15" r="9"/>
                                <circle cx="20" cy="15" r="4.5"/>
                                <path d="M14 22l-3 12 9-4 9 4-3-12"/>
                                <text x="20" y="18" text-anchor="middle" fill="#1a1a1a" stroke="none" font-size="8" font-family="Jost,sans-serif" font-weight="600">5</text>
                            </svg>
                        </div>
                        <p class="trust-label">5 Años de Garantía</p>
                    </div>

                    <div class="trust-item" style="display:flex;flex-direction:column;align-items:center;text-align:center;">
                        <div class="trust-icon">
                            <!-- Delivery truck -->
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" stroke="#1a1a1a" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="12" width="22" height="14" rx="1"/>
                                <path d="M24 18h7l5 5v5h-12z"/>
                                <circle cx="11" cy="28" r="3"/>
                                <circle cx="30" cy="28" r="3"/>
                                <line x1="14" y1="28" x2="27" y2="28"/>
                            </svg>
                        </div>
                        <p class="trust-label">Envío Gratis a Partir de $2,000</p>
                    </div>

                    <div class="trust-item" style="display:flex;flex-direction:column;align-items:center;text-align:center;">
                        <div class="trust-icon">
                            <!-- Shield / Quality -->
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" stroke="#1a1a1a" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 4L6 10v10c0 9.33 5.97 15.71 14 18 8.03-2.29 14-8.67 14-18V10L20 4z"/>
                                <polyline points="14,20 18,24 26,16"/>
                            </svg>
                        </div>
                        <p class="trust-label">Calidad Segura</p>
                    </div>

                    <div class="trust-item" style="display:flex;flex-direction:column;align-items:center;text-align:center;">
                        <div class="trust-icon">
                            <!-- Gem / Premium materials -->
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" stroke="#1a1a1a" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="8,15 20,6 32,15 20,35"/>
                                <line x1="8" y1="15" x2="32" y2="15"/>
                                <line x1="14" y1="15" x2="20" y2="35"/>
                                <line x1="26" y1="15" x2="20" y2="35"/>
                                <line x1="12" y1="15" x2="20" y2="6"/>
                                <line x1="28" y1="15" x2="20" y2="6"/>
                            </svg>
                        </div>
                        <p class="trust-label">Materiales Premium</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- ================ PRODUCT GALLERY ================ -->
        <section class="gallery-section" style="padding:64px 0;background:#fff;">
            <div class="gallery-container" style="max-width:1440px;margin:0 auto;padding:0 40px;">
                <h2 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:32px;font-weight:300;font-style:italic;text-align:center;margin-bottom:40px;color:#1a1a1a;-webkit-text-fill-color:#1a1a1a;"><em>As Seen On MV</em></h2>
                <?php
                $gallery_query = new WP_Query( array(
                    'post_type'      => 'product',
                    'posts_per_page' => 8,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'meta_query'     => array(
                        array(
                            'key'     => '_thumbnail_id',
                            'compare' => 'EXISTS',
                        ),
                    ),
                ) );

                if ( $gallery_query->have_posts() ) :
                ?>
                <div class="gallery-grid" style="display:grid;grid-template-columns:repeat(4, 1fr);gap:4px;">
                    <?php while ( $gallery_query->have_posts() ) : $gallery_query->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="gallery-item" style="display:block;position:relative;aspect-ratio:1/1;overflow:hidden;background:#f0efed;">
                        <?php the_post_thumbnail( 'medium_large', array(
                            'class' => 'gallery-item-img',
                            'style' => 'width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease,opacity 0.4s ease;',
                            'loading' => 'lazy',
                        ) ); ?>
                    </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
                <?php else : ?>
                <p style="text-align:center;color:#999;font-family:'Jost',sans-serif;font-size:14px;">Agrega productos con imagen para ver la galería.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- ================== NEWSLETTER ================== -->
        <section class="newsletter-section" style="background:#1a1a1a;color:#fff;padding:72px 20px;text-align:center;">
            <div class="newsletter-content">
                <h2 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:28px;font-weight:300;font-style:italic;line-height:1.45;margin-bottom:32px;max-width:560px;margin-left:auto;margin-right:auto;color:#fff;-webkit-text-fill-color:#fff;">Join MV Circle for early sale access, birthday treats, a discount on your first order, and more.</h2>
                <form class="newsletter-form" id="newsletter-signup-form" style="display:flex;justify-content:center;gap:0;max-width:480px;margin:0 auto 18px;">
                    <?php wp_nonce_field( 'newsletter_nonce', 'newsletter_nonce_field' ); ?>
                    <input type="email" placeholder="EMAIL ADDRESS" class="email-input" required style="flex:1;padding:14px 20px;border:none;outline:none;font-size:13px;background:rgba(255,255,255,0.08);color:#fff;border-bottom:1px solid rgba(255,255,255,0.4);font-family:'Jost',sans-serif;letter-spacing:1px;-webkit-text-fill-color:#fff;">
                    <button type="submit" class="btn btn-newsletter" style="background:#333;color:#fff;border:1px solid rgba(255,255,255,0.3);padding:14px 28px;cursor:pointer;font-family:'Jost',sans-serif;font-size:12px;font-weight:600;letter-spacing:1.2px;text-transform:uppercase;-webkit-text-fill-color:#fff;white-space:nowrap;">JOIN NOW &rarr;</button>
                </form>
                <p class="newsletter-disclaimer" style="font-size:12px;color:rgba(255,255,255,0.5);line-height:1.5;max-width:460px;margin:0 auto;font-family:'Jost',sans-serif;-webkit-text-fill-color:rgba(255,255,255,0.5);">
                    We'll update you by email + SMS and you can unsubscribe at any time &mdash; <a href="#" style="color:rgba(255,255,255,0.7);text-decoration:underline;-webkit-text-fill-color:rgba(255,255,255,0.7);">Privacy Policy</a>.
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

// ===================== HERO PARTICLES =====================
(function() {
    var canvas = document.getElementById('heroParticles');
    if (!canvas) return;
    var ctx = canvas.getContext('2d');
    var hero = canvas.parentElement;
    var mouse = { x: -9999, y: -9999 };

    function resize() {
        canvas.width  = hero.offsetWidth;
        canvas.height = hero.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    hero.addEventListener('mousemove', function(e) {
        var rect = hero.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    });
    hero.addEventListener('mouseleave', function() {
        mouse.x = -9999; mouse.y = -9999;
    });

    // Jewelry shapes: each is a function(ctx, size) that draws at (0,0)
    var shapes = [
        // Diamond ◆
        function(c, s) {
            c.beginPath();
            c.moveTo(0, -s);
            c.lineTo(s * 0.6, 0);
            c.lineTo(0, s);
            c.lineTo(-s * 0.6, 0);
            c.closePath();
        },
        // Ring ○
        function(c, s) {
            c.beginPath();
            c.arc(0, 0, s, 0, Math.PI * 2);
            c.arc(0, 0, s * 0.6, 0, Math.PI * 2, true);
        },
        // 6-point star / sparkle ✦
        function(c, s) {
            c.beginPath();
            for (var i = 0; i < 6; i++) {
                var a = (i * Math.PI) / 3 - Math.PI / 2;
                var r = (i % 2 === 0) ? s : s * 0.38;
                i === 0 ? c.moveTo(Math.cos(a) * r, Math.sin(a) * r)
                        : c.lineTo(Math.cos(a) * r, Math.sin(a) * r);
            }
            c.closePath();
        },
        // Oval gem
        function(c, s) {
            c.beginPath();
            c.ellipse(0, 0, s, s * 0.65, 0, 0, Math.PI * 2);
        },
        // Small cross / plus charm
        function(c, s) {
            var t = s * 0.28;
            c.beginPath();
            c.rect(-t, -s, t * 2, s * 2);
            c.rect(-s, -t, s * 2, t * 2);
        }
    ];

    // Gold palette
    var colors = [
        'rgba(200, 169, 81, 0.85)',
        'rgba(237, 217, 138, 0.75)',
        'rgba(210, 180, 80, 0.80)',
        'rgba(180, 150, 60, 0.90)',
        'rgba(220, 190, 100, 0.70)',
        'rgba(245, 226, 100, 0.75)',
    ];

    var NUM = 28;
    var particles = [];

    function rand(min, max) { return min + Math.random() * (max - min); }

    function createParticle() {
        return {
            x:       rand(0, canvas.width),
            y:       rand(0, canvas.height),
            vx:      rand(-0.18, 0.18),
            vy:      rand(-0.22, -0.08),
            size:    rand(7, 20),
            rot:     rand(0, Math.PI * 2),
            rotV:    rand(-0.010, 0.010),
            alpha:   0,
            alphaV:  rand(0.004, 0.009),
            alphaMax:rand(0.65, 1.0),
            fading:  false,
            shape:   Math.floor(Math.random() * shapes.length),
            color:   colors[Math.floor(Math.random() * colors.length)],
        };
    }

    for (var i = 0; i < NUM; i++) {
        var p = createParticle();
        p.alpha = rand(0, p.alphaMax); // start at random phase
        particles.push(p);
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        particles.forEach(function(p) {
            // Mouse repulsion — subtle parallax
            var dx = p.x - mouse.x;
            var dy = p.y - mouse.y;
            var dist = Math.sqrt(dx * dx + dy * dy);
            var repel = 90;
            if (dist < repel && dist > 0) {
                var force = (repel - dist) / repel * 0.4;
                p.x += (dx / dist) * force;
                p.y += (dy / dist) * force;
            }

            // Move
            p.x += p.vx;
            p.y += p.vy;

            // Fade in / out
            if (!p.fading) {
                p.alpha += p.alphaV;
                if (p.alpha >= p.alphaMax) { p.fading = true; }
            } else {
                p.alpha -= p.alphaV * 0.6;
                if (p.alpha <= 0) {
                    // Recycle
                    Object.assign(p, createParticle());
                    p.alpha = 0;
                    p.fading = false;
                }
            }

            // Wrap horizontal
            if (p.x < -20) p.x = canvas.width + 20;
            if (p.x > canvas.width + 20) p.x = -20;
            // Respawn when off top
            if (p.y < -20) {
                p.y = canvas.height + 20;
                p.x = rand(0, canvas.width);
            }

            p.rot += p.rotV;

            // Draw
            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.rot);
            ctx.globalAlpha = Math.max(0, Math.min(1, p.alpha));

            shapes[p.shape](ctx, p.size);

            // Fill + subtle stroke
            ctx.fillStyle = p.color;
            ctx.fill('evenodd');
            ctx.strokeStyle = 'rgba(200, 169, 81, 0.3)';
            ctx.lineWidth = 0.8;
            ctx.stroke();

            ctx.restore();
        });

        requestAnimationFrame(draw);
    }
    draw();
})();
</script>

<?php get_footer(); ?>