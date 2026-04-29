<?php
/**
 * Login Form override for Xavier Ecommerce
 * Simplified version to fit within a page template.
 *
 * @package WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="xv-login-form-wrapper" id="customer_login">

    <div class="xv-login-row">
        
        <!-- Login Form -->
        <div class="xv-login-col">
            <h2 class="xv-login-title-small"><?php esc_html_e( 'Acceder', 'woocommerce' ); ?></h2>
            <form class="woocommerce-form woocommerce-form-login login" method="post">
                <?php do_action( 'woocommerce_login_form_start' ); ?>

                <div class="xv-form-field">
                    <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                </div>

                <div class="xv-form-field">
                    <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input class="input-text" type="password" name="password" id="password" autocomplete="current-password" />
                </div>

                <?php do_action( 'woocommerce_login_form' ); ?>

                <div class="xv-form-actions">
                    <label class="rememberme">
                        <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                    </label>
                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                    <button type="submit" class="xv-btn-primary" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Acceder', 'woocommerce' ); ?></button>
                </div>

                <p class="lost_password">
                    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
                </p>

                <?php do_action( 'woocommerce_login_form_end' ); ?>
            </form>
        </div>

        <!-- Register Form -->
        <div class="xv-login-col">
            <h2 class="xv-login-title-small"><?php esc_html_e( 'Registrarse', 'woocommerce' ); ?></h2>
            <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
                <?php do_action( 'woocommerce_register_form_start' ); ?>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                    <div class="xv-form-field">
                        <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                    </div>
                <?php endif; ?>

                <div class="xv-form-field">
                    <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="email" class="input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" />
                </div>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                    <div class="xv-form-field">
                        <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="password" class="input-text" name="password" id="reg_password" autocomplete="new-password" />
                    </div>
                <?php else : ?>
                    <p class="xv-register-info"><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>
                <?php endif; ?>

                <?php do_action( 'woocommerce_register_form' ); ?>

                <div class="xv-form-actions">
                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                    <button type="submit" class="xv-btn-primary" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Registrarse', 'woocommerce' ); ?></button>
                </div>

                <?php do_action( 'woocommerce_register_form_end' ); ?>
            </form>
        </div>

    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
