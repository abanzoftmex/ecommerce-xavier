<?php
/**
 * Custom Single Product Page
 * Overrides WooCommerce default single-product.php
 *
 * @package Astra Child
 */

get_header(); ?>

<style>
    /* ===== Product Page Styles ===== */
    #xvProduct { max-width:1440px;margin:0 auto;padding:40px 40px 0; }
    #xvBreadcrumb { font-family:'Jost',sans-serif;font-size:13px;margin-bottom:24px; }
    #xvBreadcrumb a { color:#888;text-decoration:none;transition:color 0.2s; }
    #xvBreadcrumb a:hover { color:#1a1a1a; }
    #xvBreadcrumb span { color:#1a1a1a; }

    #xvProductLayout { display:grid!important;grid-template-columns:1fr 1fr!important;gap:60px!important;align-items:start; }

    /* Gallery */
    #xvGallery { display:grid!important;grid-template-columns:1fr 1fr!important;gap:4px!important; }
    .xv-gallery-img { width:100%;aspect-ratio:1/1;object-fit:cover;display:block!important;cursor:pointer;transition:opacity 0.3s ease;background:#f0efed; }
    .xv-gallery-img:hover { opacity:0.85; }
    .xv-gallery-img.xv-main-img { grid-column:1/-1;aspect-ratio:4/5; }

    /* Product Info */
    #xvInfo { position:sticky;top:120px; }
    #xvBackLink { display:inline-flex;align-items:center;gap:6px;font-family:'Jost',sans-serif;font-size:13px;color:#888;text-decoration:none;margin-bottom:20px;transition:color 0.2s; }
    #xvBackLink:hover { color:#1a1a1a; }
    #xvProductName { font-family:'Cormorant Garamond',Georgia,serif!important;font-size:36px!important;font-weight:300!important;line-height:1.2!important;margin-bottom:8px!important;color:#1a1a1a!important;-webkit-text-fill-color:#1a1a1a!important; }
    #xvProductSubtitle { font-family:'Jost',sans-serif;font-size:14px;color:#888;margin-bottom:16px; }
    #xvPrice { font-family:'Jost',sans-serif!important;font-size:24px!important;font-weight:500!important;color:#1a1a1a!important;-webkit-text-fill-color:#1a1a1a!important;margin-bottom:20px!important; }
    #xvPrice del { color:#999;font-weight:300;margin-right:8px;font-size:20px; }
    #xvPrice ins { text-decoration:none;color:#1a1a1a; }
    #xvRating { display:flex;align-items:center;gap:8px;margin-bottom:24px;font-family:'Jost',sans-serif;font-size:13px;color:#888; }
    #xvRating .xv-stars { color:#c8a951;font-size:16px;letter-spacing:2px; }

    #xvMeta { margin-bottom:24px;padding:20px 0;border-top:1px solid #eee;border-bottom:1px solid #eee; }
    #xvMeta p { font-family:'Jost',sans-serif;font-size:13px;color:#555;margin:6px 0;line-height:1.5; }
    #xvMeta strong { color:#1a1a1a;font-weight:500; }

    #xvDescription { font-family:'Jost',sans-serif;font-size:14px;color:#555;line-height:1.7;margin-bottom:28px; }

    /* Add to cart */
    #xvCartForm { margin-bottom:32px; }
    #xvQtyWrap { display:flex;align-items:center;gap:16px;margin-bottom:16px; }
    #xvQtyWrap label { font-family:'Jost',sans-serif;font-size:13px;font-weight:500;color:#1a1a1a;text-transform:uppercase;letter-spacing:0.8px; }
    #xvQtyWrap input[type="number"] { width:70px;padding:10px 12px;border:1px solid #ddd;font-family:'Jost',sans-serif;font-size:14px;text-align:center;outline:none;background:#fff;-webkit-appearance:none;-moz-appearance:textfield; }
    #xvAddToCart { display:block!important;width:100%!important;padding:16px 32px!important;background:#1a1a1a!important;color:#fff!important;border:none!important;font-family:'Jost',sans-serif!important;font-size:13px!important;font-weight:500!important;letter-spacing:1.5px!important;text-transform:uppercase!important;cursor:pointer!important;transition:background 0.3s ease!important;-webkit-text-fill-color:#fff!important; }
    #xvAddToCart:hover { background:#333!important; }

    /* Wishlist */
    #xvWishlist { display:flex;align-items:center;gap:8px;font-family:'Jost',sans-serif;font-size:13px;color:#888;cursor:pointer;background:none;border:none;padding:0;margin-bottom:24px;transition:color 0.2s; }
    #xvWishlist:hover { color:#c8a951; }

    /* Delivery info */
    #xvDelivery { padding:20px 0;border-top:1px solid #eee; }
    #xvDelivery p { font-family:'Jost',sans-serif;font-size:13px;color:#555;margin:8px 0;display:flex;align-items:center;gap:8px; }

    /* SKU / Categories */
    #xvProductMeta { margin-top:24px;padding-top:20px;border-top:1px solid #eee; }
    #xvProductMeta p { font-family:'Jost',sans-serif;font-size:12px;color:#888;margin:4px 0; }
    #xvProductMeta a { color:#1a1a1a;text-decoration:none; }
    #xvProductMeta a:hover { text-decoration:underline; }

    /* ===== Related Products ===== */
    #xvRelated { max-width:1440px;margin:0 auto;padding:60px 40px 80px; }
    #xvRelatedTitle { font-family:'Cormorant Garamond',Georgia,serif!important;font-size:28px!important;font-weight:300!important;font-style:italic!important;text-align:center!important;margin-bottom:40px!important;color:#1a1a1a!important;-webkit-text-fill-color:#1a1a1a!important; }
    #xvRelatedGrid { display:grid!important;grid-template-columns:repeat(4,1fr)!important;gap:24px!important; }
    .xv-related-card { text-decoration:none;display:block;transition:transform 0.3s ease; }
    .xv-related-card:hover { transform:translateY(-4px); }
    .xv-related-card img { width:100%;aspect-ratio:1/1;object-fit:cover;display:block;background:#f0efed;margin-bottom:12px; }
    .xv-related-card h3 { font-family:'Jost',sans-serif!important;font-size:14px!important;font-weight:400!important;color:#1a1a1a!important;-webkit-text-fill-color:#1a1a1a!important;margin-bottom:4px!important; }
    .xv-related-card .xv-rel-price { font-family:'Jost',sans-serif;font-size:14px;font-weight:500;color:#1a1a1a; }

    /* ===== Responsive ===== */
    @media (max-width: 900px) {
        #xvProductLayout { grid-template-columns:1fr!important;gap:32px!important; }
        #xvInfo { position:static; }
        #xvRelatedGrid { grid-template-columns:repeat(2,1fr)!important; }
    }
    @media (max-width: 600px) {
        #xvProduct { padding:20px; }
        #xvGallery { grid-template-columns:1fr!important; }
        .xv-gallery-img.xv-main-img { aspect-ratio:1/1; }
        #xvRelated { padding:40px 20px 60px; }
    }
</style>

<main id="main" class="site-main">
<div id="content" class="site-content">

<?php while ( have_posts() ) : the_post();
    global $product;
    if ( ! $product ) $product = wc_get_product( get_the_ID() );
    if ( ! $product ) continue;

    $gallery_ids = $product->get_gallery_image_ids();
    $main_image_id = $product->get_image_id();
    $categories = wc_get_product_category_list( $product->get_id(), ', ' );
    $rating_count = $product->get_rating_count();
    $average_rating = $product->get_average_rating();
?>

<div id="xvProduct">
    <!-- Breadcrumb -->
    <nav id="xvBreadcrumb">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> /
        <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">Tienda</a> /
        <?php
        $terms = get_the_terms( get_the_ID(), 'product_cat' );
        if ( $terms && ! is_wp_error( $terms ) ) :
            $term = $terms[0];
        ?>
            <a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a> /
        <?php endif; ?>
        <span><?php the_title(); ?></span>
    </nav>

    <div id="xvProductLayout">
        <!-- ===== LEFT: Gallery ===== -->
        <div id="xvGallery">
            <?php if ( $main_image_id ) : ?>
                <img src="<?php echo esc_url( wp_get_attachment_image_url( $main_image_id, 'large' ) ); ?>" alt="<?php the_title_attribute(); ?>" class="xv-gallery-img xv-main-img" />
            <?php endif; ?>

            <?php if ( ! empty( $gallery_ids ) ) : ?>
                <?php foreach ( $gallery_ids as $gid ) : ?>
                    <img src="<?php echo esc_url( wp_get_attachment_image_url( $gid, 'medium_large' ) ); ?>" alt="<?php echo esc_attr( get_post_meta( $gid, '_wp_attachment_image_alt', true ) ?: get_the_title() ); ?>" class="xv-gallery-img" />
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- ===== RIGHT: Product Info ===== -->
        <div id="xvInfo">
            <?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
                <a id="xvBackLink" href="<?php echo esc_url( get_term_link( $terms[0] ) ); ?>">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    <?php echo esc_html( $terms[0]->name ); ?>
                </a>
            <?php endif; ?>

            <h1 id="xvProductName"><?php the_title(); ?></h1>

            <?php
            $tagline = $product->get_attribute( 'pa_finish' );
            if ( ! $tagline ) $tagline = $product->get_short_description();
            if ( $tagline ) :
            ?>
                <p id="xvProductSubtitle"><?php echo wp_strip_all_tags( $tagline ); ?></p>
            <?php endif; ?>

            <div id="xvPrice"><?php echo $product->get_price_html(); ?></div>

            <?php if ( $rating_count > 0 ) : ?>
            <div id="xvRating">
                <span class="xv-stars"><?php
                    $full = floor( $average_rating );
                    $half = ( $average_rating - $full ) >= 0.5 ? 1 : 0;
                    echo str_repeat( '★', $full );
                    if ( $half ) echo '★';
                    echo str_repeat( '☆', 5 - $full - $half );
                ?></span>
                <span><?php echo esc_html( number_format( $average_rating, 1 ) ); ?></span>
                <span>(<?php echo esc_html( $rating_count ); ?>)</span>
            </div>
            <?php endif; ?>

            <?php if ( $product->get_short_description() ) : ?>
                <div id="xvDescription"><?php echo wpautop( $product->get_short_description() ); ?></div>
            <?php endif; ?>

            <!-- Add to Cart -->
            <div id="xvCartForm">
                <?php if ( $product->is_type( 'simple' ) && $product->is_in_stock() ) : ?>
                    <form action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype="multipart/form-data">
                        <div id="xvQtyWrap">
                            <label for="xvQty">Cantidad</label>
                            <input type="number" id="xvQty" name="quantity" value="1" min="1" max="<?php echo esc_attr( $product->get_max_purchase_quantity() > 0 ? $product->get_max_purchase_quantity() : '' ); ?>" />
                        </div>
                        <button type="submit" id="xvAddToCart" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>">AÑADIR AL CARRITO &rarr;</button>
                    </form>
                <?php elseif ( $product->is_type( 'variable' ) ) : ?>
                    <?php woocommerce_variable_add_to_cart(); ?>
                <?php elseif ( ! $product->is_in_stock() ) : ?>
                    <p style="font-family:'Jost',sans-serif;font-size:14px;color:#c0392b;font-weight:500;">Agotado</p>
                <?php endif; ?>
            </div>

            <button id="xvWishlist" type="button">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                Agregar a favoritos
            </button>

            <!-- Delivery Info -->
            <div id="xvDelivery">
                <p>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Envío gratis a partir de $2,000
                </p>
                <p>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 3v4h-7z"/></svg>
                    5 Años de garantía
                </p>
            </div>

            <!-- SKU / Categories -->
            <div id="xvProductMeta">
                <?php if ( $product->get_sku() ) : ?>
                    <p>SKU: <?php echo esc_html( $product->get_sku() ); ?></p>
                <?php endif; ?>
                <?php if ( $categories ) : ?>
                    <p>Categoría: <?php echo $categories; ?></p>
                <?php endif; ?>
                <?php
                $tags = wc_get_product_tag_list( $product->get_id(), ', ' );
                if ( $tags ) :
                ?>
                    <p>Etiquetas: <?php echo $tags; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- ===== RELATED PRODUCTS ===== -->
<?php
$related_ids = wc_get_related_products( $product->get_id(), 8 );
if ( ! empty( $related_ids ) ) :
    $related_query = new WP_Query( array(
        'post_type'      => 'product',
        'post__in'       => $related_ids,
        'posts_per_page' => 4,
        'orderby'        => 'rand',
    ) );
    if ( $related_query->have_posts() ) :
?>
<div id="xvRelated">
    <h2 id="xvRelatedTitle"><em>Tal vez te interese</em></h2>
    <div id="xvRelatedGrid">
        <?php while ( $related_query->have_posts() ) : $related_query->the_post();
            $rel_product = wc_get_product( get_the_ID() );
        ?>
        <a href="<?php the_permalink(); ?>" class="xv-related-card">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium_large', array( 'style' => 'width:100%;aspect-ratio:1/1;object-fit:cover;display:block;background:#f0efed;margin-bottom:12px;' ) ); ?>
            <?php else : ?>
                <div style="width:100%;aspect-ratio:1/1;background:#f0efed;margin-bottom:12px;"></div>
            <?php endif; ?>
            <h3><?php the_title(); ?></h3>
            <span class="xv-rel-price"><?php echo $rel_product ? $rel_product->get_price_html() : ''; ?></span>
        </a>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</div>
<?php endif; endif; ?>

<?php endwhile; ?>

</div>
</main>

<?php get_footer(); ?>
