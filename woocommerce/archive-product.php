<?php
/**
 * Custom Shop / Product Archive Page
 * Overrides WooCommerce default archive-product.php
 *
 * @package Astra Child
 */

get_header(); ?>

<style>
    /* ===== Shop Page ===== */
    #xvShop { max-width:1440px;margin:0 auto;padding:40px 40px 80px; }

    /* Header */
    #xvShopHeader { text-align:center;margin-bottom:48px; }
    #xvShopTitle { font-family:'Cormorant Garamond',Georgia,serif!important;font-size:42px!important;font-weight:300!important;line-height:1.2!important;color:#1a1a1a!important;-webkit-text-fill-color:#1a1a1a!important;margin-bottom:12px!important; }
    #xvShopCount { font-family:'Jost',sans-serif;font-size:13px;color:#888;margin-bottom:32px; }

    /* Category Filter */
    #xvCatFilter { display:flex!important;flex-wrap:wrap!important;justify-content:center!important;gap:10px!important;margin-bottom:48px!important; }
    .xv-cat-pill { display:inline-block;padding:8px 22px;font-family:'Jost',sans-serif;font-size:12px;font-weight:500;letter-spacing:0.8px;text-transform:uppercase;text-decoration:none;border:1px solid #ddd;color:#555;background:#fff;cursor:pointer;transition:all 0.25s ease;white-space:nowrap; }
    .xv-cat-pill:hover { border-color:#1a1a1a;color:#1a1a1a; }
    .xv-cat-pill.xv-active { background:#1a1a1a;color:#fff;border-color:#1a1a1a;-webkit-text-fill-color:#fff; }

    /* Sort bar */
    #xvSortBar { display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid #eee; }
    #xvResultCount { font-family:'Jost',sans-serif;font-size:13px;color:#888; }
    #xvSortSelect { font-family:'Jost',sans-serif;font-size:13px;color:#1a1a1a;padding:8px 12px;border:1px solid #ddd;background:#fff;cursor:pointer;outline:none; }

    /* Product Grid */
    #xvProductGrid { display:grid!important;grid-template-columns:repeat(4,1fr)!important;gap:24px!important; }
    .xv-product-card { text-decoration:none;display:block;position:relative; }
    .xv-product-card:hover .xv-card-img { opacity:0.9;transform:scale(1.02); }
    .xv-card-img-wrap { position:relative;overflow:hidden;background:#f0efed;margin-bottom:14px; }
    .xv-card-img { width:100%;aspect-ratio:3/4;object-fit:cover;display:block!important;transition:opacity 0.3s ease,transform 0.4s ease; }
    .xv-card-img-placeholder { width:100%;aspect-ratio:3/4;background:#e8e6e3;display:flex;align-items:center;justify-content:center;color:#bbb;font-family:'Jost',sans-serif;font-size:13px; }
    .xv-card-badge { position:absolute;top:12px;left:12px;background:#1a1a1a;color:#fff;font-family:'Jost',sans-serif;font-size:10px;font-weight:600;letter-spacing:0.8px;text-transform:uppercase;padding:4px 10px;z-index:2; }
    .xv-card-badge.xv-sale { background:#c0392b; }
    .xv-card-name { font-family:'Jost',sans-serif!important;font-size:14px!important;font-weight:400!important;color:#1a1a1a!important;-webkit-text-fill-color:#1a1a1a!important;margin-bottom:4px!important;line-height:1.4; }
    .xv-card-price { font-family:'Jost',sans-serif;font-size:14px;font-weight:500;color:#1a1a1a; }
    .xv-card-price del { color:#999;font-weight:300;margin-right:6px;font-size:13px; }
    .xv-card-price ins { text-decoration:none; }
    .xv-card-cat { font-family:'Jost',sans-serif;font-size:11px;color:#888;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px; }

    /* Quick add */
    .xv-quick-add { position:absolute;bottom:0;left:0;right:0;background:rgba(26,26,26,0.92);color:#fff;text-align:center;padding:10px;font-family:'Jost',sans-serif;font-size:11px;font-weight:500;letter-spacing:1px;text-transform:uppercase;opacity:0;transform:translateY(8px);transition:opacity 0.3s ease,transform 0.3s ease;cursor:pointer;border:none;width:100%; }
    .xv-card-img-wrap:hover .xv-quick-add { opacity:1;transform:translateY(0); }

    /* Pagination */
    #xvPagination { margin-top:48px;display:flex;justify-content:center;gap:8px; }
    #xvPagination a, #xvPagination span { display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;font-family:'Jost',sans-serif;font-size:14px;text-decoration:none;color:#1a1a1a;border:1px solid #ddd;transition:all 0.2s ease; }
    #xvPagination a:hover { border-color:#1a1a1a; }
    #xvPagination span.current { background:#1a1a1a;color:#fff;border-color:#1a1a1a; }

    /* No products */
    #xvNoProducts { text-align:center;padding:80px 20px;font-family:'Jost',sans-serif;font-size:16px;color:#888; }

    /* Responsive */
    @media (max-width:1024px) { #xvProductGrid { grid-template-columns:repeat(3,1fr)!important; } }
    @media (max-width:768px) { #xvProductGrid { grid-template-columns:repeat(2,1fr)!important; } #xvShop { padding:20px 20px 60px; } }
    @media (max-width:480px) { #xvProductGrid { grid-template-columns:1fr!important; } }
</style>

<main id="main" class="site-main">
<div id="content" class="site-content">
<div id="xvShop">

    <!-- Shop Header -->
    <div id="xvShopHeader">
        <h1 id="xvShopTitle"><?php
            if ( is_product_category() ) {
                single_cat_title();
            } elseif ( is_search() ) {
                echo 'Resultados para: ' . esc_html( get_search_query() );
            } else {
                echo 'Tienda';
            }
        ?></h1>
        <?php
        $total = $wp_query->found_posts;
        if ( $total ) :
        ?>
            <p id="xvShopCount"><?php echo esc_html( $total ); ?> producto<?php echo $total !== 1 ? 's' : ''; ?></p>
        <?php endif; ?>
    </div>

    <!-- Category Filter Pills -->
    <?php
    $product_cats = get_terms( array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'parent'     => 0,
        'exclude'    => array( get_option( 'default_product_cat' ) ),
    ) );
    $current_cat = is_product_category() ? get_queried_object_id() : 0;
    $shop_url = get_permalink( wc_get_page_id( 'shop' ) );

    if ( ! empty( $product_cats ) && ! is_wp_error( $product_cats ) ) :
    ?>
    <div id="xvCatFilter">
        <a href="<?php echo esc_url( $shop_url ); ?>" class="xv-cat-pill <?php echo ! $current_cat ? 'xv-active' : ''; ?>">Todos</a>
        <?php foreach ( $product_cats as $cat ) : ?>
            <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="xv-cat-pill <?php echo $current_cat === $cat->term_id ? 'xv-active' : ''; ?>"><?php echo esc_html( $cat->name ); ?></a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Sort Bar -->
    <div id="xvSortBar">
        <span id="xvResultCount">Mostrando <?php echo esc_html( $wp_query->post_count ); ?> de <?php echo esc_html( $total ); ?> productos</span>
        <form method="get">
            <select id="xvSortSelect" name="orderby" onchange="this.form.submit()">
                <?php
                $orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : 'date';
                $options = array(
                    'date'       => 'Más recientes',
                    'popularity' => 'Más popular',
                    'rating'     => 'Mejor valorados',
                    'price'      => 'Precio: menor a mayor',
                    'price-desc' => 'Precio: mayor a menor',
                );
                foreach ( $options as $val => $label ) :
                ?>
                    <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $orderby, $val ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <!-- Product Grid -->
    <?php if ( have_posts() ) : ?>
    <div id="xvProductGrid">
        <?php while ( have_posts() ) : the_post();
            global $product;
            if ( ! $product ) $product = wc_get_product( get_the_ID() );
            if ( ! $product ) continue;

            $is_on_sale = $product->is_on_sale();
            $is_featured = $product->is_featured();
            $terms = get_the_terms( get_the_ID(), 'product_cat' );
            $cat_name = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
        ?>
        <div class="xv-product-card">
            <div class="xv-card-img-wrap">
                <?php if ( $is_on_sale ) : ?>
                    <span class="xv-card-badge xv-sale">Oferta</span>
                <?php elseif ( $is_featured ) : ?>
                    <span class="xv-card-badge">Destacado</span>
                <?php endif; ?>

                <a href="<?php the_permalink(); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium_large', array(
                            'class' => 'xv-card-img',
                            'loading' => 'lazy',
                        ) ); ?>
                    <?php else : ?>
                        <div class="xv-card-img-placeholder">Sin imagen</div>
                    <?php endif; ?>
                </a>

                <?php if ( $product->is_type( 'simple' ) && $product->is_in_stock() ) : ?>
                    <form method="post" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', '' ) ); ?>">
                        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
                        <input type="hidden" name="quantity" value="1" />
                        <button type="submit" class="xv-quick-add">AÑADIR AL CARRITO</button>
                    </form>
                <?php endif; ?>
            </div>

            <a href="<?php the_permalink(); ?>" style="text-decoration:none;">
                <?php if ( $cat_name ) : ?>
                    <p class="xv-card-cat"><?php echo esc_html( $cat_name ); ?></p>
                <?php endif; ?>
                <h3 class="xv-card-name"><?php the_title(); ?></h3>
                <div class="xv-card-price"><?php echo $product->get_price_html(); ?></div>
            </a>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <div id="xvPagination">
        <?php
        echo paginate_links( array(
            'total'     => $wp_query->max_num_pages,
            'current'   => max( 1, get_query_var( 'paged' ) ),
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
            'type'      => 'plain',
        ) );
        ?>
    </div>

    <?php else : ?>
        <div id="xvNoProducts">
            <p>No se encontraron productos.</p>
            <a href="<?php echo esc_url( $shop_url ); ?>" style="display:inline-block;margin-top:20px;padding:12px 28px;background:#1a1a1a;color:#fff;text-decoration:none;font-family:'Jost',sans-serif;font-size:13px;letter-spacing:1px;text-transform:uppercase;">Ver todos los productos</a>
        </div>
    <?php endif; ?>

</div>
</div>
</main>

<?php get_footer(); ?>
