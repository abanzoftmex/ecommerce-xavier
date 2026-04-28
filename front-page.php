<?php
/**
 * Template: Página de Inicio (Front Page)
 * Child Theme Override — Astra Child / Ecommerce Xavier
 *
 * GUÍA RÁPIDA PARA EDITAR ESTA PÁGINA:
 * ─────────────────────────────────────────────────────────────
 * • COLORES PRINCIPALES: busca en style.css la sección "PALETTE LOCK"
 *   Los colores base son:
 *     #1a1a1a = negro/oscuro principal
 *     #c8a951 = dorado de la marca
 *     #f0efed = crema de fondo
 *     #fff    = blanco
 * • TIPOGRAFÍAS: el sitio usa dos fuentes:
 *     'Cormorant Garamond' → para títulos elegantes
 *     'Jost'              → para textos y botones
 * • SECCIONES DE ESTA PÁGINA (en orden):
 *     1. HERO           — el gran banner con título y botones
 *     2. CATEGORÍAS     — carrusel de categorías de producto
 *     3. TRENDING       — productos destacados/trending
 *     4. RECOMENDADOS   — carrusel de productos populares
 *     5. TRUST BADGES   — íconos de garantías (envío, calidad…)
 *     6. GALERÍA        — cuadrícula de productos recientes
 *     7. NEWSLETTER     — sección de suscripción por email
 * ─────────────────────────────────────────────────────────────
 *
 * @package Astra Child
 */

get_header();
?>

<div id="primary" class="content-area child-front-page">
    <main id="main" class="site-main home-main" role="main">

        <!-- ═══════════════════════════════════════════════════════════
             SECCIÓN 1: HERO — Banner principal de la página de inicio
             ═══════════════════════════════════════════════════════════
             PARA EDITAR EL TÍTULO GRANDE: busca <h1 id="heroTitle">
             PARA EDITAR LOS BOTONES: busca <a id="heroBtnPrimary"> y <a id="heroBtnSecondary">
             PARA CAMBIAR EL COLOR DE FONDO DEL HERO: edita background-color:#f0efed
             PARA CAMBIAR EL TAMAÑO DEL TÍTULO: edita font-size:48px en el bloque <style>
             Los puntitos animados (partículas doradas) se controlan en el script al final -->
        <!-- ===================== HERO ===================== -->
        <?php
        $shop_url = function_exists( 'wc_get_page_id' )
            ? get_permalink( wc_get_page_id( 'shop' ) )
            : home_url( '/shop/' );
        $uploads     = wp_get_upload_dir();
        $hero_bg_url = trailingslashit( $uploads['baseurl'] ) . '2026/04/fdo_anika1.webp';
        ?>
        <style>
            #primary.child-front-page { margin:0!important;padding:0!important; }
            #main.home-main { margin:0!important;padding:0!important; }
            #heroSection { position:relative;width:100%;min-height:540px;overflow:hidden;display:flex!important;align-items:center;background-color:#f0efed!important;background-image:url('<?php echo esc_url( $hero_bg_url ); ?>')!important;background-size:cover!important;background-position:center!important;background-repeat:no-repeat!important;isolation:isolate; }
            #heroCanvas { position:absolute;inset:0;width:100%;height:100%;z-index:-1;pointer-events:none;display:block!important; }
            #heroContent { position:relative!important;z-index:10!important;display:block!important;visibility:visible!important;opacity:1!important;padding:80px!important;max-width:480px!important; }
            #heroTitle { color:#1a1a1a!important;font-family:'Cormorant Garamond',Georgia,serif!important;font-size:48px!important;font-weight:300!important;line-height:1.15!important;margin-bottom:36px!important;visibility:visible!important;opacity:1!important;display:block!important;background:none!important;-webkit-text-fill-color:#1a1a1a!important; text-shadow:0 2px 10px rgba(255,255,255,0.45); }
            #heroTitle em { font-style:italic!important;color:#1a1a1a!important;-webkit-text-fill-color:#1a1a1a!important; }
            #heroButtons { display:flex!important;gap:16px!important;flex-wrap:wrap!important;visibility:visible!important;opacity:1!important; }
            #heroButtons a { display:inline-block!important;padding:12px 24px!important;font-family:'Jost',sans-serif!important;font-size:12px!important;font-weight:500!important;text-transform:uppercase!important;letter-spacing:1.2px!important;text-decoration:none!important;border-radius:0!important;visibility:visible!important;opacity:1!important; }
            #heroBtnPrimary { background:#1a1a1a!important;color:#fff!important;border:1.5px solid #1a1a1a!important;-webkit-text-fill-color:#fff!important; }
            #heroBtnSecondary { background:transparent!important;color:#1a1a1a!important;border:1.5px solid #1a1a1a!important;-webkit-text-fill-color:#1a1a1a!important; }

            @media (max-width: 980px) {
                #heroSection { min-height:460px!important; }
                #heroContent { padding:56px 24px 40px!important; max-width:100%!important; }
                #heroTitle { font-size:44px!important; line-height:1.02!important; margin-bottom:24px!important; }
                #heroButtons { width:100%!important; gap:10px!important; }
                #heroButtons a { width:100%!important; text-align:center!important; }
            }
        </style>
        <section id="heroSection">
            <canvas id="heroCanvas" class="hero-particles-canvas"></canvas>
            <div id="heroContent">
                <div>
                    <h1 id="heroTitle"><em>Anika</em>.<br>Joyería que trasciende.</h1>
                    <div id="heroButtons">
                        <a id="heroBtnPrimary" href="<?php echo esc_url( $shop_url ); ?>">Ver catálogo</a>
                    </div>
                </div>
            </div>
        </section>


        <!-- ═══════════════════════════════════════════════════════════
             SECCIÓN 2: CARRUSEL DE CATEGORÍAS
             ═══════════════════════════════════════════════════════════
             Las categorías se administran desde:
             WordPress → Productos → Categorías
             PARA CAMBIAR EL TÍTULO: busca <h2>Compra por categoría</h2>
             PARA CAMBIAR EL BOTÓN INFERIOR: busca <a ...>VER TODOS LOS PRODUCTOS
             Las imágenes de categoría se asignan en WordPress → Productos → Categorías → editar -->
        <!-- ================ SHOP BY CATEGORY ================ -->
        <section class="category-section">
            <div class="category-container">
                <div class="category-header">
                    <h2>Compra por categoría</h2>
                    <div class="category-nav">
                        <button class="cat-nav-btn cat-prev" aria-label="Anterior">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M15 6l-6 6 6 6"></path>
                            </svg>
                        </button>
                        <button class="cat-nav-btn cat-next" aria-label="Siguiente">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M9 6l6 6-6 6"></path>
                            </svg>
                        </button>
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
                                    ? wp_get_attachment_image_url( $thumbnail_id, 'high' )
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
                                <div class="category-label-wrap">
                                    <p class="category-label"><?php echo esc_html( strtoupper( $cat->name ) ); ?></p>
                                </div>
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
                    <a href="<?php echo esc_url( $shop_url ); ?>" class="btn-shopall">VER TODOS LOS PRODUCTOS &rarr;</a>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════
             SECCIÓN 3: PRODUCTOS TRENDING
             ═══════════════════════════════════════════════════════════
             Muestra los 2 productos más recientes de la categoría "trending"
             Si no existe la categoría "trending", muestra los 2 más nuevos
             PARA CREAR LA CATEGORÍA: WordPress → Productos → Categorías → crear "trending"
             PARA CAMBIAR CUÁNTOS PRODUCTOS MUESTRA: edita posts_per_page => 2
             PARA CAMBIAR EL BOTÓN "Comprar ahora": busca class="btn-comprar" -->
        <!-- ================ TRENDING PRODUCTS ================ -->
        <?php
        $newest_args = array(
            'post_type'      => 'product',
            'posts_per_page' => 4,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        $newest_query = new WP_Query( $newest_args );
        ?>
        <?php if ( $newest_query->have_posts() ) : ?>
        <section class="trending-section">
            <div class="trending-container">
                <h2 class="trending-title">Lo Más Nuevo</h2>
                <div class="trending-grid" id="xvHomeNewGrid">
                    <?php while ( $newest_query->have_posts() ) : $newest_query->the_post();
                        global $product;
                        if ( ! $product ) {
                            $product = wc_get_product( get_the_ID() );
                        }
                        if ( ! $product ) {
                            continue;
                        }
                        $is_on_sale  = $product->is_on_sale();
                        $is_featured = $product->is_featured();
                        $terms       = get_the_terms( get_the_ID(), 'product_cat' );
                        $cat_name    = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
                        $xv_show_add = $product->is_type( 'simple' ) && $product->is_in_stock();
                    ?>
                    <div class="xv-product-card" data-favorite-card="<?php echo esc_attr( $product->get_id() ); ?>">
                        <div class="xv-card-img-wrap">
                            <?php if ( $is_on_sale ) : ?>
                                <span class="xv-card-badge xv-sale">Oferta</span>
                            <?php elseif ( $is_featured ) : ?>
                                <span class="xv-card-badge">Destacado</span>
                            <?php endif; ?>
                            <button type="button" class="xv-favorite-toggle" data-product-id="<?php echo esc_attr( get_the_ID() ); ?>" aria-label="Agregar a favoritos" aria-pressed="false">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                    <path fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </button>
                            <a href="<?php the_permalink(); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium_large', array( 'class' => 'xv-card-img', 'loading' => 'lazy' ) ); ?>
                                <?php else : ?>
                                    <div class="xv-card-img-placeholder">Sin imagen</div>
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="xv-card-info">
                            <a href="<?php the_permalink(); ?>" class="xv-card-info-main">
                                <?php if ( $cat_name ) : ?>
                                    <p class="xv-card-cat"><?php echo esc_html( $cat_name ); ?></p>
                                <?php endif; ?>
                                <h3 class="xv-card-name"><?php the_title(); ?></h3>
                                <div class="xv-card-price"><?php echo $product->get_price_html(); ?></div>
                            </a>
                            <div class="xv-card-actions<?php echo $xv_show_add ? ' xv-card-actions--pair' : ''; ?>">
                                <a href="<?php the_permalink(); ?>" class="xv-card-btn--detail"><?php esc_html_e( 'Ver detalles', 'astra-child' ); ?></a>
                                <?php if ( $xv_show_add ) : ?>
                                    <form method="post" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>">
                                        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
                                        <input type="hidden" name="quantity" value="1" />
                                        <button type="submit" class="xv-quick-add"><?php esc_html_e( 'Agregar al carrito', 'astra-child' ); ?></button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ═══════════════════════════════════════════════════════════
             SECCIÓN 4: CARRUSEL "CREEMOS QUE TE PUEDE GUSTAR"
             ═══════════════════════════════════════════════════════════
             PARA CAMBIAR EL TÍTULO: busca <h2>Creemos que te puede gustar
             PARA CAMBIAR CUÁNTOS PRODUCTOS MUESTRA: edita posts_per_page => 8
             Los productos se ordenan por popularidad (ventas) automáticamente -->
        <!-- ================ WE THINK YOU MAY LIKE ================ -->
        <section class="recommended-section">
            <div class="recommended-container">
                <div class="recommended-header">
                    <h2>Creemos que te puede gustar&hellip;</h2>
                    <div class="rec-nav">
                        <button class="rec-nav-btn rec-prev" aria-label="Anterior">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M15 6l-6 6 6 6"></path>
                            </svg>
                        </button>
                        <button class="rec-nav-btn rec-next" aria-label="Siguiente">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M9 6l6 6-6 6"></path>
                            </svg>
                        </button>
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
                                if ( ! $product ) {
                                    continue;
                                }
                                $is_on_sale  = $product->is_on_sale();
                                $is_featured = $product->is_featured();
                                $terms       = get_the_terms( get_the_ID(), 'product_cat' );
                                $cat_name    = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
                                $xv_show_add = $product->is_type( 'simple' ) && $product->is_in_stock();
                        ?>
                        <div class="xv-product-card" data-favorite-card="<?php echo esc_attr( $product->get_id() ); ?>">
                            <div class="xv-card-img-wrap">
                            <?php if ( $is_on_sale ) : ?>
                                <span class="xv-card-badge xv-sale">Oferta</span>
                            <?php elseif ( $is_featured ) : ?>
                                <span class="xv-card-badge">Destacado</span>
                            <?php endif; ?>
                            <button type="button" class="xv-favorite-toggle" data-product-id="<?php echo esc_attr( get_the_ID() ); ?>" aria-label="Agregar a favoritos" aria-pressed="false">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                    <path fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </button>
                            <a href="<?php the_permalink(); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium_large', array( 'class' => 'xv-card-img', 'loading' => 'lazy' ) ); ?>
                                <?php else : ?>
                                    <div class="xv-card-img-placeholder">Sin imagen</div>
                                <?php endif; ?>
                            </a>
                            </div>
                            <div class="xv-card-info">
                                <a href="<?php the_permalink(); ?>" class="xv-card-info-main">
                                    <?php if ( $cat_name ) : ?>
                                        <p class="xv-card-cat"><?php echo esc_html( $cat_name ); ?></p>
                                    <?php endif; ?>
                                    <h3 class="xv-card-name"><?php the_title(); ?></h3>
                                    <div class="xv-card-price"><?php echo $product->get_price_html(); ?></div>
                                </a>
                                <div class="xv-card-actions<?php echo $xv_show_add ? ' xv-card-actions--pair' : ''; ?>">
                                    <a href="<?php the_permalink(); ?>" class="xv-card-btn--detail"><?php esc_html_e( 'Ver detalles', 'astra-child' ); ?></a>
                                    <?php if ( $xv_show_add ) : ?>
                                        <form method="post" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>">
                                            <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
                                            <input type="hidden" name="quantity" value="1" />
                                            <button type="submit" class="xv-quick-add"><?php esc_html_e( 'Agregar al carrito', 'astra-child' ); ?></button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
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

        <!-- ═══════════════════════════════════════════════════════════
             SECCIÓN 5: ÍCONOS DE CONFIANZA (Garantía, Envío, Calidad…)
             ═══════════════════════════════════════════════════════════
             PARA CAMBIAR EL TEXTO DE CADA ÍCONO: busca class="trust-label"
             Ejemplo: <p class="trust-label">5 Años de Garantía</p>
             PARA CAMBIAR LOS ÍCONOS: son SVG dibujados en código.
             Si prefieres imágenes, reemplaza el bloque <svg>...</svg>
             por <img src="tu-imagen.png" style="width:40px;"> -->
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

        <!-- ═══════════════════════════════════════════════════════════
             SECCIÓN 6: GALERÍA DE PRODUCTOS RECIENTES
             ═══════════════════════════════════════════════════════════
             Muestra los últimos 8 productos que tengan imagen asignada
             PARA CAMBIAR EL TÍTULO ITÁLICO: busca <em>Nuestro últimos lanzamientos</em>
             PARA CAMBIAR EL FONDO: edita background:#fff en el style del <section>
             PARA CAMBIAR CUÁNTOS MUESTRA: edita posts_per_page => 8
             PARA CAMBIAR LAS COLUMNAS: edita grid-template-columns:repeat(4, 1fr) -->
        <!-- ================ PRODUCT GALLERY ================ -->
        <section class="gallery-section" style="padding:64px 0;background:#fff;">
            <div class="gallery-container" style="max-width:1440px;margin:0 auto;padding:0 40px;">
                <h2 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:32px;font-weight:300;font-style:italic;text-align:center;margin-bottom:40px;color:#1a1a1a;-webkit-text-fill-color:#1a1a1a;"><em>Nuestro últimos lanzamientos</em></h2>
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

        <!-- ═══════════════════════════════════════════════════════════
             SECCIÓN 7: SUSCRIPCIÓN AL NEWSLETTER
             ═══════════════════════════════════════════════════════════
             PARA CAMBIAR EL COLOR DE FONDO: edita background:#1a1a1a  (negro actual)
             PARA CAMBIAR EL TEXTO DEL TÍTULO: busca el <h2> dentro de esta sección
             PARA CAMBIAR EL TEXTO DEL BOTÓN: busca >INSCRÍBETE AHORA
             PARA CAMBIAR EL TEXTO LEGAL: busca class="newsletter-disclaimer"
             El formulario envía los datos por WordPress (wp_mail) -->
        <!-- ================== NEWSLETTER ================== -->
        <section class="newsletter-section" style="background:#1a1a1a;color:#fff;padding:72px 20px;text-align:center;">
            <div class="newsletter-content">
                <h2 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:28px;font-weight:300;font-style:italic;line-height:1.45;margin-bottom:32px;max-width:560px;margin-left:auto;margin-right:auto;color:#fff;-webkit-text-fill-color:#fff;">Inscríbete a nuestos avisos para recibir nuestras últimas novedades y ofertas exclusivas.</h2>
                <form class="newsletter-form" id="newsletter-signup-form" style="display:flex;justify-content:center;gap:0;max-width:480px;margin:0 auto 18px;">
                    <?php wp_nonce_field( 'newsletter_nonce', 'newsletter_nonce_field' ); ?>
                    <input type="email" placeholder="EMAIL ADDRESS" class="email-input" required style="flex:1;padding:14px 20px;border:none;outline:none;font-size:13px;background:rgba(255,255,255,0.08);color:#fff;border-bottom:1px solid rgba(255,255,255,0.4);font-family:'Jost',sans-serif;letter-spacing:1px;-webkit-text-fill-color:#fff;">
                    <button type="submit" class="btn btn-newsletter" style="background:#333;color:#fff;border:1px solid rgba(255,255,255,0.3);padding:14px 28px;cursor:pointer;font-family:'Jost',sans-serif;font-size:12px;font-weight:600;letter-spacing:1.2px;text-transform:uppercase;-webkit-text-fill-color:#fff;white-space:nowrap;">INSCRÍBETE AHORA &rarr;</button>
                </form>
                <p class="newsletter-disclaimer" style="font-size:12px;color:rgba(255,255,255,0.5);line-height:1.5;max-width:460px;margin:0 auto;font-family:'Jost',sans-serif;-webkit-text-fill-color:rgba(255,255,255,0.5);">
                    Te mantendremos informado por correo electrónico, y puedes darte de baja en cualquier momento &mdash; <a href="#" style="color:rgba(255,255,255,0.7);text-decoration:underline;-webkit-text-fill-color:rgba(255,255,255,0.7);">Política de privacidad</a>.
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
        var card = recTrack && recTrack.querySelector('.xv-product-card');
        return card ? card.offsetWidth + 24 : 240;
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
    var canvas = document.getElementById('heroCanvas');
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