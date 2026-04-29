<?php
/**
 * Template Name: Mi Cuenta Template
 *
 * A custom page template for the WooCommerce My Account page,
 * following the design distribution of the About page.
 *
 * @package Astra Child
 */

get_header();

$is_logged_in = is_user_logged_in();
$user_name    = $is_logged_in ? wp_get_current_user()->display_name : '';
?>

<main id="primary" class="content-area xv-about-page xv-account-page">
    
    <!-- Hero Section -->
    <section class="xv-about-hero">
        <div class="xv-about-container">
            <?php if ( $is_logged_in ) : ?>
                <h1>Hola, <?php echo esc_html( $user_name ); ?></h1>
                <p>Bienvenido de nuevo a tu espacio personal en ANIKA. Aquí puedes revisar tus pedidos recientes, gestionar tus direcciones de envío y actualizar los detalles de tu cuenta.</p>
            <?php else : ?>
                <h1>Tu cuenta en ANIKA</h1>
                <p>Únete a nuestra comunidad para disfrutar de una experiencia de compra personalizada, seguimiento de pedidos y acceso exclusivo a nuestras nuevas colecciones.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Content Section -->
    <section class="xv-about-block">
        <div class="xv-about-container">
            <div class="xv-account-content-wrap">
                <?php
                while ( have_posts() ) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>
        </div>
    </section>

    <!-- Support Section (Mirroring About Page "Promesa") -->
    <?php if ( ! $is_logged_in ) : ?>
    <section class="xv-about-block" style="padding-top: 0;">
        <div class="xv-about-grid">
            <article class="xv-about-card">
                <h2>¿Por qué crear una cuenta?</h2>
                <p>
                    Tener una cuenta en ANIKA te permite agilizar tus compras, guardar tus piezas favoritas en tu lista de deseos 
                    y tener un historial completo de tus adquisiciones. Además, recibirás actualizaciones sobre el estado de tus envíos en tiempo real.
                </p>
            </article>

            <aside class="xv-about-highlight">
                <h3>Ayuda con tu cuenta</h3>
                <p>
                    Si tienes problemas para acceder o alguna duda sobre tu perfil, nuestro equipo de atención está listo para apoyarte.
                </p>
                <div style="margin-top: 20px;">
                    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" style="color: #c8a951; text-decoration: none; font-family: 'Jost', sans-serif; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Contactar Soporte &rarr;</a>
                </div>
            </aside>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
