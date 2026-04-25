<?php
/**
 * Child Theme - Ecommerce Xavier (Astra Child)
 *
 * @package Astra Child
 */

// =============================================
// 1. ESTILOS DEL CHILD THEME
// =============================================

function astra_child_enqueue_styles() {
    // Astra carga su propio CSS con el handle 'astra-theme-css'.
    // Encolamos el child DESPUÉS de ese handle para asegurar cascada correcta.
    $parent_handle = wp_style_is( 'astra-theme-css', 'registered' ) ? 'astra-theme-css' : false;
    $deps = $parent_handle ? array( $parent_handle ) : array();
    $theme_version = wp_get_theme()->get( 'Version' );
    $style_path    = get_stylesheet_directory() . '/style.css';
    $style_version = file_exists( $style_path ) ? filemtime( $style_path ) : $theme_version;
    $wishlist_path = get_stylesheet_directory() . '/assets/js/xavier-wishlist.js';
    $wishlist_ver  = file_exists( $wishlist_path ) ? filemtime( $wishlist_path ) : $theme_version;

    wp_enqueue_style(
        'astra-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        $deps,
        $style_version
    );

    // Google Fonts – Cormorant Garamond (editorial serif) + Jost (clean sans)
    wp_enqueue_style(
        'astra-child-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap',
        array(),
        null
    );

    wp_enqueue_script(
        'xavier-wishlist',
        get_stylesheet_directory_uri() . '/assets/js/xavier-wishlist.js',
        array(),
        $wishlist_ver,
        true
    );

    $shop_page_id = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0;
    $shop_url     = $shop_page_id > 0 ? get_permalink( $shop_page_id ) : home_url( '/shop/' );

    wp_localize_script(
        'xavier-wishlist',
        'xavierWishlist',
        array(
            'storageKey'      => 'xv_favorites',
            'cookieName'      => 'xv_favorites',
            'favoritesPageUrl'=> add_query_arg( 'xv_favorites', '1', $shop_url ),
            'inFavoritesView' => ( isset( $_GET['xv_favorites'] ) && '1' === sanitize_text_field( wp_unslash( $_GET['xv_favorites'] ) ) ) ? 1 : 0,
        )
    );
}
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles', 20 );

// =============================================
// 1b. WISHLIST HELPERS
// =============================================

function astra_child_get_favorite_ids_from_cookie() {
    $raw_value = isset( $_COOKIE['xv_favorites'] ) ? wp_unslash( $_COOKIE['xv_favorites'] ) : '';

    if ( '' === $raw_value ) {
        return array();
    }

    $raw_value = sanitize_text_field( $raw_value );
    $ids       = array();

    if ( '[' === substr( $raw_value, 0, 1 ) ) {
        $decoded = json_decode( $raw_value, true );
        if ( is_array( $decoded ) ) {
            $ids = $decoded;
        }
    } else {
        $ids = explode( ',', $raw_value );
    }

    $ids = array_map( 'absint', (array) $ids );
    $ids = array_filter( $ids );
    $ids = array_values( array_unique( $ids ) );

    return $ids;
}

function astra_child_get_favorite_ids_from_request() {
    if ( ! isset( $_GET['xv_ids'] ) ) {
        return array();
    }

    $raw_value = wp_unslash( $_GET['xv_ids'] );

    if ( is_array( $raw_value ) ) {
        $raw_value = implode( ',', $raw_value );
    }

    $raw_value = sanitize_text_field( (string) $raw_value );

    if ( '' === $raw_value ) {
        return array();
    }

    $ids = array_map( 'absint', explode( ',', $raw_value ) );
    $ids = array_filter( $ids );
    $ids = array_values( array_unique( $ids ) );

    return $ids;
}

function astra_child_is_favorites_view() {
    return isset( $_GET['xv_favorites'] ) && '1' === sanitize_text_field( wp_unslash( $_GET['xv_favorites'] ) );
}

function astra_child_apply_favorites_filter_to_shop( $query ) {
    if ( is_admin() || ! $query->is_main_query() || ! astra_child_is_favorites_view() ) {
        return;
    }

    $is_product_listing = $query->is_post_type_archive( 'product' ) || $query->is_tax( array( 'product_cat', 'product_tag' ) );

    if ( ! $is_product_listing ) {
        return;
    }

    $favorite_ids = astra_child_get_favorite_ids_from_request();

    if ( empty( $favorite_ids ) ) {
        $favorite_ids = astra_child_get_favorite_ids_from_cookie();
    }

    if ( empty( $favorite_ids ) ) {
        $query->set( 'post__in', array( 0 ) );
        return;
    }

    $query->set( 'post__in', $favorite_ids );
    $query->set( 'orderby', 'post__in' );
}
add_action( 'pre_get_posts', 'astra_child_apply_favorites_filter_to_shop' );

add_action( 'template_redirect', function() {
    if ( ! astra_child_is_favorites_view() ) {
        return;
    }

    if ( ! defined( 'DONOTCACHEPAGE' ) ) {
        define( 'DONOTCACHEPAGE', true );
    }

    nocache_headers();
}, 0 );


// =============================================
// 2. SOPORTE PARA WOOCOMMERCE
// =============================================

function astra_child_woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'astra_child_woocommerce_support' );

/**
 * Prioritizar productos con imágenes y en existencia (In Stock).
 * Esto asegura que el catálogo se vea siempre lleno y profesional.
 */
add_filter( 'posts_clauses', 'astra_child_custom_product_sorting', 100, 2 );
function astra_child_custom_product_sorting( $clauses, $query ) {
    global $wpdb;

    // Solo aplicar en el frente, en el query principal de la tienda/categorías
    if ( is_admin() || ! $query->is_main_query() ) {
        return $clauses;
    }

    if ( is_shop() || is_product_category() || is_product_tag() || ( isset( $query->query_vars['post_type'] ) && 'product' === $query->query_vars['post_type'] ) ) {
        
        // Unimos con postmeta para stock y para imágenes
        $clauses['join'] .= " LEFT JOIN {$wpdb->postmeta} AS xv_stock ON ({$wpdb->posts}.ID = xv_stock.post_id AND xv_stock.meta_key = '_stock_status') ";
        $clauses['join'] .= " LEFT JOIN {$wpdb->postmeta} AS xv_thumb ON ({$wpdb->posts}.ID = xv_thumb.post_id AND xv_thumb.meta_key = '_thumbnail_id') ";

        // Lógica de orden:
        // 1. Stock (instock primero)
        // 2. Tiene imagen (thumbnail_id no vacío primero)
        // 3. El orden original (fecha, precio, etc)
        $stock_order = " CASE WHEN xv_stock.meta_value = 'instock' THEN 0 ELSE 1 END ASC ";
        $thumb_order = " CASE WHEN xv_thumb.meta_value IS NOT NULL AND xv_thumb.meta_value != '' THEN 0 ELSE 1 END ASC ";

        if ( empty( $clauses['orderby'] ) ) {
            $clauses['orderby'] = " $stock_order, $thumb_order, {$wpdb->posts}.post_date DESC ";
        } else {
            $clauses['orderby'] = " $stock_order, $thumb_order, " . $clauses['orderby'];
        }
    }

    return $clauses;
}

// Productos por página en la tienda
add_filter( 'loop_shop_per_page', function() { return 8; }, 20 );

// Texto del botón "Añadir al carrito"
add_filter( 'woocommerce_product_add_to_cart_text', function( $text, $product ) {
    return ( $product->get_type() === 'simple' ) ? 'Add to Cart' : $text;
}, 10, 2 );

// Actualizar contador del carrito (AJAX)
function astra_child_cart_fragments( $fragments ) {
    if ( function_exists( 'WC' ) ) {
        $count = WC()->cart->get_cart_contents_count();
        $fragments['.cart-count'] = '<span class="cart-count">' . $count . '</span>';
    }
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'astra_child_cart_fragments' );

// =============================================
// 3. MENÚS Y TAMAÑOS DE IMÁGENES
// =============================================

add_action( 'init', function() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'astra-child' ),
        'footer'  => __( 'Footer Menu',  'astra-child' ),
    ) );
} );

add_action( 'after_setup_theme', function() {
    add_image_size( 'product-thumb',  300, 300, true );
    add_image_size( 'product-medium', 600, 600, true );
} );

// =============================================
// 4. CLASES DEL BODY
// =============================================

add_filter( 'body_class', function( $classes ) {
    if ( is_front_page() ) {
        $classes[] = 'home-page';
        $classes[] = 'child-theme-active';
    }
    return $classes;
} );

// =============================================
// 4b. DESACTIVAR HEADER DE ASTRA
// =============================================

// Remove Astra's default header
add_action( 'after_setup_theme', function() {
    remove_action( 'astra_header', 'astra_header_markup' );
    remove_action( 'astra_masthead', 'astra_masthead_primary_template' );
}, 99 );

// Ensure no Astra header elements are visible
add_action( 'wp_head', function() {
    echo '<style>
        .ast-primary-header-bar,
        .ast-mobile-header-wrap,
        #ast-desktop-header,
        #ast-mobile-header,
        .ast-above-header-wrap,
        .ast-below-header-wrap,
        .ast-main-header-wrap,
        [data-section="section-header-builder"],
        .ast-header-break-point .ast-mobile-header-wrap { 
            display: none !important; 
            height: 0 !important;
            min-height: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            overflow: hidden !important;
        }
    </style>';
}, 999 );

// =============================================
// 5. BREADCRUMBS WOOCOMMERCE
// =============================================

add_filter( 'woocommerce_breadcrumb_defaults', function() {
    return array(
        'delimiter'   => ' / ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
    );
} );

// =============================================
// 6. SHORTCODE PRODUCTOS DESTACADOS
// =============================================

add_shortcode( 'featured_products', function( $atts ) {
    $atts = shortcode_atts( array( 'limit' => 8, 'columns' => 4 ), $atts );
    ob_start();
    $q = new WP_Query( array(
        'post_type'      => 'product',
        'posts_per_page' => (int) $atts['limit'],
        'meta_query'     => array( array(
            'key'     => '_featured',
            'value'   => 'yes',
            'compare' => '=',
        ) ),
    ) );
    if ( $q->have_posts() ) {
        echo '<div class="featured-products-shortcode">';
        woocommerce_product_loop_start();
        while ( $q->have_posts() ) {
            $q->the_post();
            wc_get_template_part( 'content', 'product' );
        }
        woocommerce_product_loop_end();
        echo '</div>';
        wp_reset_postdata();
    }
    return ob_get_clean();
} );

// =============================================
// 7. CUSTOM WALKER — CATÁLOGO MEGA-DROPDOWN
// =============================================

/**
 * Extends Walker_Nav_Menu to auto-inject a WooCommerce categories dropdown
 * beneath any menu item whose title is "Catálogo" (case-insensitive) or
 * that has the custom CSS class "has-catalog-dropdown".
 */
class Xavier_Catalog_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        // Tag the LI before the parent generates it
        if ( $depth === 0 && $this->is_catalog_item( $item ) ) {
            $item->classes[] = 'xv-has-dropdown';
        }
        parent::start_el( $output, $item, $depth, $args, $id );

        // Append the dropdown HTML right after the <a> (still inside the <li>)
        if ( $depth === 0 && $this->is_catalog_item( $item ) ) {
            $output .= $this->catalog_dropdown_html();
        }
    }

    private function is_catalog_item( $item ) {
        return mb_strtolower( trim( $item->title ) ) === 'catálogo'
            || in_array( 'has-catalog-dropdown', (array) $item->classes, true );
    }

    private function catalog_dropdown_html() {
        if ( ! function_exists( 'get_terms' ) ) return '';

        $cats = get_terms( array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'parent'     => 0,
            'exclude'    => array( get_option( 'default_product_cat' ) ),
            'orderby'    => 'name',
            'order'      => 'ASC',
        ) );

        if ( empty( $cats ) || is_wp_error( $cats ) ) return '';

        $shop_url = function_exists( 'wc_get_page_id' )
            ? get_permalink( wc_get_page_id( 'shop' ) )
            : home_url( '/shop/' );

        $html  = '<div class="xv-megamenu" style="display: none !important; visibility: hidden !important; opacity: 0 !important;">';
        $html .= '<div class="xv-megamenu__inner">';
        $html .= '<div class="xv-megamenu__header">';
        $html .= '<h3 class="xv-megamenu__title">Nuestras Colecciones</h3>';
        $html .= '<p class="xv-megamenu__subtitle">Encuentra la joya perfecta</p>';
        $html .= '</div>';
        $html .= '<ul class="xv-megamenu__list">';

        foreach ( $cats as $cat ) {
            $html .= '<li><a href="' . esc_url( get_term_link( $cat ) ) . '" class="xv-megamenu__link">'
                   . esc_html( $cat->name )
                   . '</a></li>';
        }

        $html .= '</ul>';
        $html .= '<a href="' . esc_url( $shop_url ) . '" class="xv-megamenu__all">Ver todo el catálogo &rarr;</a>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}

// =============================================
// 8. NEWSLETTER AJAX
// =============================================

function astra_child_newsletter_signup() {
    if ( ! wp_verify_nonce( $_POST['nonce'] ?? '', 'newsletter_nonce' ) ) {
        wp_send_json_error( 'Security check failed' );
    }
    $email = sanitize_email( $_POST['email'] ?? '' );
    if ( ! is_email( $email ) ) {
        wp_send_json_error( 'Invalid email address' );
    }
    wp_send_json_success( 'Successfully subscribed!' );
}
add_action( 'wp_ajax_newsletter_signup',        'astra_child_newsletter_signup' );
add_action( 'wp_ajax_nopriv_newsletter_signup', 'astra_child_newsletter_signup' );
