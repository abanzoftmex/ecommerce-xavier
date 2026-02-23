<?php
/**
 * Child Theme - Ecommerce Xavier
 * Toma control total sobre Astra + Elementor
 *
 * @package Astra Child
 */

// =============================================
// 1. ESTILOS DEL CHILD THEME
// =============================================

function astra_child_enqueue_styles() {
    // Cargar CSS del padre primero, luego el nuestro
    wp_enqueue_style(
        'astra-theme-css',
        get_template_directory_uri() . '/style.css'
    );
    wp_enqueue_style(
        'astra-child-style',
        get_stylesheet_uri(),
        array( 'astra-theme-css' ),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles', 1 );

// =============================================
// 2. DESACTIVAR ELEMENTOR EN TODA LA JERARQUÍA
//    QUE NOS INTERESA CONTROLAR
// =============================================

/**
 * Desactiva el ThemeBuilder de Elementor Pro en la front page.
 * Corre en prioridad muy alta para quitar sus filtros
 * ANTES de que los ejecute.
 */
function astra_child_kill_elementor_on_front( $template ) {

    if ( ! is_front_page() ) {
        return $template;
    }

    // Elementor Pro ThemeBuilder → prioridad 12
    if ( class_exists( '\ElementorPro\Plugin' ) ) {
        $module = \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'theme-builder' );
        if ( $module ) {
            remove_filter( 'template_include', [ $module, 'template_include' ], 12 );
        }
    }

    // Elementor básico frontend → prioridad 11
    if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->frontend ) ) {
        remove_filter(
            'template_include',
            [ \Elementor\Plugin::$instance->frontend, 'apply_builder_in_content' ],
            11
        );
    }

    // Devolver nuestro template del child theme
    $child_template = get_stylesheet_directory() . '/front-page.php';
    if ( file_exists( $child_template ) ) {
        return $child_template;
    }

    return $template;
}
// Prioridad 999 para correr DESPUÉS de Elementor (12) y ANY page builder
add_filter( 'template_include', 'astra_child_kill_elementor_on_front', 999 );

// =============================================
// 3. DESACTIVAR HOOKS DE ASTRA QUE
//    INYECTAN CONTENIDO EN LA FRONT PAGE
// =============================================

function astra_child_disable_astra_overrides() {
    if ( ! is_front_page() ) {
        return;
    }
    // Header builder de Astra Pro
    remove_action( 'astra_header',  'astra_header_markup' );
    remove_action( 'astra_footer',  'astra_footer_markup' );
    // Contenido de Astra
    remove_action( 'astra_content_before', 'astra_primary_content_top' );
    remove_action( 'astra_content_after',  'astra_primary_content_bottom' );
    remove_action( 'astra_content_loop',   'astra_content_loop' );
}
add_action( 'wp', 'astra_child_disable_astra_overrides', 5 );

// Apagar Header Builder de Astra Pro globalmente en front page
add_filter( 'astra_header_enabled', function( $enabled ) {
    return is_front_page() ? false : $enabled;
} );

// =============================================
// 4. SOPORTE PARA WOOCOMMERCE
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

// Actualizar fragmento del contador del carrito (AJAX)
function astra_child_cart_fragments( $fragments ) {
    if ( function_exists( 'WC' ) ) {
        $count = WC()->cart->get_cart_contents_count();
        $fragments['.cart-count'] = '<span class="cart-count">' . $count . '</span>';
    }
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'astra_child_cart_fragments' );

// =============================================
// 5. MENÚS Y SOPORTE DE IMÁGENES
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
// 6. CLASES DEL BODY
// =============================================

add_filter( 'body_class', function( $classes ) {
    if ( is_front_page() ) {
        $classes[] = 'home-page';
        $classes[] = 'child-theme-active'; // ← útil para debug desde DevTools
    }
    return $classes;
} );

// =============================================
// 7. BREADCRUMBS PERSONALIZADOS DE WOOCOMMERCE
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
// 8. SHORTCODE PRODUCTOS DESTACADOS
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
// 9. NEWSLETTER AJAX
// =============================================

function astra_child_newsletter_signup() {
    if ( ! wp_verify_nonce( $_POST['nonce'] ?? '', 'newsletter_nonce' ) ) {
        wp_send_json_error( 'Security check failed' );
    }
    $email = sanitize_email( $_POST['email'] ?? '' );
    if ( ! is_email( $email ) ) {
        wp_send_json_error( 'Invalid email address' );
    }
    // TODO: integrar con servicio de email marketing (Mailchimp, etc.)
    wp_send_json_success( 'Successfully subscribed!' );
}
add_action( 'wp_ajax_newsletter_signup',        'astra_child_newsletter_signup' );
add_action( 'wp_ajax_nopriv_newsletter_signup', 'astra_child_newsletter_signup' );
