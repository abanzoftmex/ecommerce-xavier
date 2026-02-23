<?php
/**
 * Template fallback principal del child theme.
 * WordPress usa este archivo cuando ningún otro template más específico aplica.
 * En la front page se usa front-page.php directamente.
 *
 * @package Astra Child
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
        else :
            echo '<p>' . esc_html__( 'No content found.', 'astra-child' ) . '</p>';
        endif;
        ?>
    </main>
</div>

<?php get_footer(); ?>
