<?php
/**
 * About page template for slug: /about
 *
 * @package Astra Child
 */

get_header();

$shop_url = function_exists( 'wc_get_page_id' )
    ? get_permalink( wc_get_page_id( 'shop' ) )
    : home_url( '/shop/' );

$contact_url = home_url( '/contact/' );
?>

<main id="primary" class="content-area xv-about-page">
    <section class="xv-about-hero">
        <div class="xv-about-container">
            <h1>Nuestra historia se crea pieza por pieza</h1>
            <p>
                En ANIKA diseñamos joyería contemporánea con intención: formas limpias, materiales seleccionados y detalles que
                acompañan tu estilo todos los días. Creemos en piezas que se sienten personales y trascienden temporadas.
            </p>
        </div>
    </section>

    <section class="xv-about-block">
        <div class="xv-about-grid">
            <article class="xv-about-card">
                <h2>Quiénes somos</h2>
                <p>
                    Somos una marca mexicana inspirada por la estética editorial y la elegancia minimalista. Nuestro equipo combina
                    diseño, técnica artesanal y procesos responsables para ofrecer piezas versátiles que elevan cualquier look.
                </p>
                <p>
                    Desde Val'Quirico, creamos colecciones que mezclan carácter, delicadeza y una paleta atemporal para que cada
                    accesorio cuente tu historia con autenticidad.
                </p>
            </article>

            <aside class="xv-about-highlight">
                <h3>Nuestra promesa</h3>
                <p>
                    Diseñar joyas con identidad, acabados cuidados y atención cercana. Cada compra importa, por eso cuidamos la
                    experiencia completa: desde la selección de la pieza hasta la entrega final.
                </p>
            </aside>
        </div>

        <div class="xv-about-values">
            <h2>Lo que nos define</h2>
            <ul>
                <li>Diseño intencional con líneas limpias y detalles memorables.</li>
                <li>Calidad en materiales y procesos para una larga vida útil.</li>
                <li>Atención personalizada antes, durante y después de tu compra.</li>
                <li>Colecciones pensadas para combinarse y evolucionar contigo.</li>
            </ul>
        </div>

        <div class="xv-about-cta">
            <a class="xv-about-primary" href="<?php echo esc_url( $shop_url ); ?>">Explorar la tienda</a>
            <a class="xv-about-secondary" href="<?php echo esc_url( $contact_url ); ?>">Hablar con nuestro equipo</a>
        </div>
    </section>
</main>

<?php get_footer(); ?>
