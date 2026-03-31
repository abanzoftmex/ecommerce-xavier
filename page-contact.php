<?php
/**
 * Contact page template for slug: /contact
 *
 * @package Astra Child
 */

get_header();

$xv_contact_notice_type = '';
$xv_contact_notice_text = '';

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['xv_contact_form_submitted'] ) ) {
    $xv_nonce = isset( $_POST['xv_contact_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['xv_contact_nonce'] ) ) : '';

    if ( ! wp_verify_nonce( $xv_nonce, 'xv_contact_form' ) ) {
        $xv_contact_notice_type = 'error';
        $xv_contact_notice_text = 'No pudimos validar el envío. Intenta nuevamente.';
    } else {
        $xv_honeypot = isset( $_POST['xv_contact_website'] ) ? trim( wp_unslash( $_POST['xv_contact_website'] ) ) : '';

        if ( '' !== $xv_honeypot ) {
            $xv_contact_notice_type = 'error';
            $xv_contact_notice_text = 'No fue posible enviar tu mensaje.';
        } else {
            $xv_name    = isset( $_POST['xv_name'] ) ? sanitize_text_field( wp_unslash( $_POST['xv_name'] ) ) : '';
            $xv_email   = isset( $_POST['xv_email'] ) ? sanitize_email( wp_unslash( $_POST['xv_email'] ) ) : '';
            $xv_phone   = isset( $_POST['xv_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['xv_phone'] ) ) : '';
            $xv_subject = isset( $_POST['xv_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['xv_subject'] ) ) : '';
            $xv_message = isset( $_POST['xv_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['xv_message'] ) ) : '';

            if ( '' === $xv_name || '' === $xv_email || '' === $xv_message || ! is_email( $xv_email ) ) {
                $xv_contact_notice_type = 'error';
                $xv_contact_notice_text = 'Completa los campos obligatorios y verifica tu correo.';
            } else {
                $xv_to      = get_option( 'admin_email' );
                $xv_subject = $xv_subject ? $xv_subject : 'Nuevo mensaje desde /contact';
                $xv_body    = "Nombre: {$xv_name}\n";
                $xv_body   .= "Email: {$xv_email}\n";
                $xv_body   .= "Teléfono: {$xv_phone}\n\n";
                $xv_body   .= "Mensaje:\n{$xv_message}\n";

                $xv_headers = array( 'Reply-To: ' . $xv_name . ' <' . $xv_email . '>' );
                $xv_sent    = wp_mail( $xv_to, $xv_subject, $xv_body, $xv_headers );

                if ( $xv_sent ) {
                    $xv_contact_notice_type = 'success';
                    $xv_contact_notice_text = 'Gracias, recibimos tu mensaje. Te responderemos pronto.';
                } else {
                    $xv_contact_notice_type = 'error';
                    $xv_contact_notice_text = 'Ocurrió un problema al enviar. Escríbenos directamente por WhatsApp o correo.';
                }
            }
        }
    }
}
?>

<main id="primary" class="content-area xv-contact-page">
    <section class="xv-contact-hero">
        <div class="xv-contact-hero-inner">
            <p class="xv-contact-kicker">CONTACTO</p>
            <h1>Estamos para ayudarte con tu compra</h1>
            <p class="xv-contact-intro">Si tienes dudas sobre piezas, envíos, tallas o pedidos especiales, nuestro equipo te responde de forma personalizada.</p>
            <div class="xv-contact-tags">
                <span>Atención de lunes a sábado</span>
                <span>Respuesta en menos de 24 h</span>
                <span>Pedidos especiales disponibles</span>
            </div>
        </div>
    </section>

    <section class="xv-contact-main">
        <div class="xv-contact-grid">
            <aside class="xv-contact-cards" aria-label="Información de contacto">
                <article class="xv-contact-card">
                    <h2>WhatsApp</h2>
                    <p>+52 222 000 0000</p>
                    <a href="https://wa.me/522220000000" target="_blank" rel="noopener">Enviar mensaje</a>
                </article>

                <article class="xv-contact-card">
                    <h2>Email</h2>
                    <p>hola@xavierjoyeria.com</p>
                    <a href="mailto:hola@xavierjoyeria.com">Escribir correo</a>
                </article>

                <article class="xv-contact-card">
                    <h2>Visítanos</h2>
                    <p>Val'Quirico, Tlaxcala</p>
                    <a href="https://maps.google.com" target="_blank" rel="noopener">Ver ubicación</a>
                </article>
            </aside>

            <div class="xv-contact-form-wrap">
                <h2>Cuéntanos cómo te podemos ayudar</h2>
                <p>Completa este formulario y nos pondremos en contacto contigo lo antes posible.</p>

                <?php if ( '' !== $xv_contact_notice_text ) : ?>
                    <div class="xv-contact-notice xv-contact-notice-<?php echo esc_attr( $xv_contact_notice_type ); ?>">
                        <?php echo esc_html( $xv_contact_notice_text ); ?>
                    </div>
                <?php endif; ?>

                <form class="xv-contact-form" method="post" action="<?php echo esc_url( get_permalink() ); ?>">
                    <?php wp_nonce_field( 'xv_contact_form', 'xv_contact_nonce' ); ?>
                    <input type="hidden" name="xv_contact_form_submitted" value="1" />

                    <p class="xv-honeypot" aria-hidden="true">
                        <label for="xv_contact_website">Sitio web</label>
                        <input type="text" id="xv_contact_website" name="xv_contact_website" tabindex="-1" autocomplete="off" />
                    </p>

                    <div class="xv-contact-row">
                        <div class="xv-field">
                            <label for="xv_name">Nombre completo *</label>
                            <input type="text" id="xv_name" name="xv_name" required />
                        </div>
                        <div class="xv-field">
                            <label for="xv_email">Correo electrónico *</label>
                            <input type="email" id="xv_email" name="xv_email" required />
                        </div>
                    </div>

                    <div class="xv-contact-row">
                        <div class="xv-field">
                            <label for="xv_phone">Teléfono</label>
                            <input type="text" id="xv_phone" name="xv_phone" />
                        </div>
                        <div class="xv-field">
                            <label for="xv_subject">Asunto</label>
                            <input type="text" id="xv_subject" name="xv_subject" />
                        </div>
                    </div>

                    <div class="xv-field">
                        <label for="xv_message">Mensaje *</label>
                        <textarea id="xv_message" name="xv_message" rows="6" required></textarea>
                    </div>

                    <button type="submit" class="xv-contact-submit">Enviar mensaje</button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
