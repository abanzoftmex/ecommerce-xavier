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

    wp_enqueue_style(
        'astra-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        $deps,
        wp_get_theme()->get( 'Version' )
    );

    // Google Fonts – Cormorant Garamond (editorial serif) + Jost (clean sans)
    wp_enqueue_style(
        'astra-child-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap',
        array(),
        null
    );
}
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles', 20 );


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
        // Label removed per user request
        $html .= '<ul class="xv-megamenu__list">';

        foreach ( $cats as $cat ) {
            $html .= '<li><a href="' . esc_url( get_term_link( $cat ) ) . '" class="xv-megamenu__link" style="color: #333 !important;">'
                   . '<span style="color: #333 !important;">' . esc_html( $cat->name ) . '</span>'
                   . '</a></li>';
        }

        $html .= '</ul>';
        $html .= '<a href="' . esc_url( $shop_url ) . '" class="xv-megamenu__all" style="color: #333 !important;">Ver todo el catálogo &rarr;</a>';
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
