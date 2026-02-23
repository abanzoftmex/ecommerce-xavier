<?php
/**
 * Plugin Name: Xavier Theme Override
 * Description: Fuerza el uso de front-page.php del child theme.
 *              Corre antes que todo y no puede ser desactivado.
 * Version: 2.0
 */

/**
 * PASO 1: Forzar que WordPress use la página estática como portada.
 * Si "page_on_front" tiene un valor (ID de página), activa el modo estático.
 * Esto compensa si los Reading Settings se resetean.
 */
add_action( 'init', function() {
    $front_page_id = (int) get_option( 'page_on_front' );

    if ( $front_page_id > 0 ) {
        // Asegurarnos de que WordPress está en modo "página estática"
        // aunque show_on_front haya sido cambiado a 'posts'
        add_filter( 'pre_option_show_on_front', function() {
            return 'page';
        } );
    }
}, 1 );

/**
 * PASO 2: Forzar el archivo front-page.php del child theme con
 *         la prioridad más alta posible.
 */
add_filter( 'template_include', function( $template ) {

    if ( ! is_front_page() ) {
        return $template;
    }

    $child_dir       = get_stylesheet_directory();
    $front_page_file = $child_dir . '/front-page.php';

    if ( file_exists( $front_page_file ) ) {
        return $front_page_file;
    }

    return $template;

}, PHP_INT_MAX );

/**
 * PASO 3: Desactivar el header builder de Astra para la front page
 *         y limpiar todos los hooks que interfieran.
 */
add_action( 'wp', function() {
    if ( ! is_front_page() ) {
        return;
    }
    // Quitar hooks de Astra que inyectan su propio header/footer/content
    remove_action( 'astra_header',  'astra_header_markup' );
    remove_action( 'astra_footer',  'astra_footer_markup' );
    remove_action( 'astra_content_loop', 'astra_primary_content_top' );
}, 5 );
