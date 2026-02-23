<?php
/**
 * Plugin Name: Xavier Theme Override
 * Description: Fuerza el uso de front-page.php del child theme en la página de inicio.
 *              Este mu-plugin corre antes que todo y no puede ser desactivado.
 * Version: 1.0
 */

/**
 * Interceptamos template_include con la mayor prioridad posible.
 * Al devolver la ruta absoluta de nuestro front-page.php, WordPress
 * lo usa directamente sin pasar por la lógica interna de Astra.
 */
add_filter( 'template_include', function( $template ) {

    if ( ! is_front_page() ) {
        return $template;
    }

    $child_theme_dir  = get_stylesheet_directory();
    $front_page_file  = $child_theme_dir . '/front-page.php';

    if ( file_exists( $front_page_file ) ) {
        return $front_page_file;
    }

    return $template;

}, PHP_INT_MAX ); // PHP_INT_MAX = prioridad máxima posible (corre al final de todo)
