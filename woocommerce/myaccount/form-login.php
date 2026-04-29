<?php
/**
 * Login Form override for Xavier Ecommerce
 *
 * @package WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="xv-login-page-wrapper">
    <div class="xv-login-container">
        
        <div class="xv-login-header">
            <h1 class="xv-login-title"><?php esc_html_e( 'Mi Cuenta', 'woocommerce' ); ?></h1>
            <p class="xv-login-subtitle"><?php esc_html_e( 'Bienvenido a ANIKA. Accede a tu cuenta o crea una nueva para gestionar tus pedidos.', 'astra-child' ); ?></p>
        </div>

        <div class="u-columns col2-set xv-login-grid" id="customer_login">

            <div class="u-column1 col-1 xv-login-column xv-login-form-side">
                <div class="xv-login-card">
                    <h2 class="xv-login-section-title"><?php esc_html_e( 'Acceder', 'woocommerce' ); ?></h2>

                    <form class="woocommerce-form woocommerce-form-login login" method="post">

                        <?php do_action( 'woocommerce_login_form_start' ); ?>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide xv-field">
                            <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                        </p>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide xv-field">
                            <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                            <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
                        </p>

                        <?php do_action( 'woocommerce_login_form' ); ?>

                        <div class="xv-login-actions">
                            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                            </label>
                            <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                            <button type="submit" class="woocommerce-button button woocommerce-form-login__submit xv-btn-primary" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Acceder', 'woocommerce' ); ?></button>
                        </div>

                        <p class="woocommerce-LostPassword lost_password">
                            <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
                        </p>

                        <?php do_action( 'woocommerce_login_form_end' ); ?>

                    </form>
                </div>
            </div>

            <div class="u-column2 col-2 xv-login-column xv-register-form-side">
                <div class="xv-login-card">
                    <h2 class="xv-login-section-title"><?php esc_html_e( 'Registrarse', 'woocommerce' ); ?></h2>

                    <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                        <?php do_action( 'woocommerce_register_form_start' ); ?>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide xv-field">
                                <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                            </p>
                        <?php endif; ?>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide xv-field">
                            <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                        </p>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide xv-field">
                                <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
                            </p>
                        <?php else : ?>
                            <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>
                        <?php endif; ?>

                        <?php do_action( 'woocommerce_register_form' ); ?>

                        <div class="xv-login-actions">
                            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                            <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit xv-btn-primary" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Registrarse', 'woocommerce' ); ?></button>
                        </div>

                        <?php do_action( 'woocommerce_register_form_end' ); ?>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
