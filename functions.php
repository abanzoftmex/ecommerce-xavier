<?php
function astra_child_enqueue_styles() {
    wp_enqueue_style(
        'astra-child-style',
        get_stylesheet_uri(),
        array('astra-theme-css'),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'astra_child_enqueue_styles');

// Registrar menús
function register_custom_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'text-domain'),
        'footer' => __('Footer Menu', 'text-domain'),
    ));
}
add_action('init', 'register_custom_menus');

// Soporte para WooCommerce
function add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'add_woocommerce_support' );

// Personalizar productos por página
function custom_products_per_page($products) {
    return 8;
}
add_filter('loop_shop_per_page', 'custom_products_per_page', 20);

// Agregar clase al body para páginas específicas
function custom_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'home-page';
    }
    return $classes;
}
add_filter('body_class', 'custom_body_classes');

// Personalizar el hook de WooCommerce para el carrito
function update_cart_count_fragments($fragments) {
    if (function_exists('WC')) {
        $cart_count = WC()->cart->get_cart_contents_count();
        $fragments['.cart-count'] = '<span class="cart-count">' . $cart_count . '</span>';
    }
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'update_cart_count_fragments');

// Enqueue scripts personalizados
function enqueue_custom_scripts() {
    wp_enqueue_script(
        'custom-scripts',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    // Localizar script para AJAX
    wp_localize_script('custom-scripts', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Función para obtener productos destacados
function get_featured_products($limit = 8) {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'meta_query' => array(
            array(
                'key' => '_featured',
                'value' => 'yes',
                'compare' => '='
            )
        )
    );
    
    return new WP_Query($args);
}

// Shortcode para productos destacados
function featured_products_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 8,
        'columns' => 4
    ), $atts);
    
    ob_start();
    
    $featured_query = get_featured_products($atts['limit']);
    
    if ($featured_query->have_posts()) :
        echo '<div class="featured-products-shortcode">';
        woocommerce_product_loop_start();
        
        while ($featured_query->have_posts()) :
            $featured_query->the_post();
            wc_get_template_part('content', 'product');
        endwhile;
        
        woocommerce_product_loop_end();
        echo '</div>';
        wp_reset_postdata();
    endif;
    
    return ob_get_clean();
}
add_shortcode('featured_products', 'featured_products_shortcode');

// Personalizar breadcrumbs de WooCommerce
function custom_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' / ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
    );
}
add_filter( 'woocommerce_breadcrumb_defaults', 'custom_woocommerce_breadcrumbs' );

// Agregar soporte para imágenes de productos
function add_image_sizes() {
    add_image_size('product-thumb', 300, 300, true);
    add_image_size('product-medium', 600, 600, true);
}
add_action('after_setup_theme', 'add_image_sizes');

// Personalizar texto del botón de agregar al carrito
function custom_add_to_cart_text($text, $product) {
    if ($product->get_type() === 'simple') {
        return 'Add to Cart';
    }
    return $text;
}
add_filter('woocommerce_product_add_to_cart_text', 'custom_add_to_cart_text', 10, 2);

// AJAX para newsletter signup
function handle_newsletter_signup() {
    if (!wp_verify_nonce($_POST['nonce'], 'newsletter_nonce')) {
        wp_die('Security check failed');
    }
    
    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error('Invalid email address');
    }
    
    // Aquí puedes agregar la lógica para guardar el email en tu sistema
    // Por ejemplo, en una tabla personalizada o conectar con un servicio de email marketing
    
    wp_send_json_success('Successfully subscribed to newsletter');
}
add_action('wp_ajax_newsletter_signup', 'handle_newsletter_signup');
add_action('wp_ajax_nopriv_newsletter_signup', 'handle_newsletter_signup');
