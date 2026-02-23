<?php
/**
 * Header personalizado para el child theme
 * 
 * @package Astra Child
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <!-- Announcement Bar -->
    <div class="announcement-bar">
        Enjoy 20% Off Your First Order: Code <a href="<?php echo esc_url( home_url('/shop/') ); ?>"><strong>HEY20</strong></a>
    </div>

    <header id="masthead" class="site-header">
        <!-- Top Navigation Bar -->
        <nav class="main-navigation">
            <div class="nav-container" style="display:flex;align-items:center;justify-content:space-between;gap:24px;padding:16px 40px;max-width:1440px;margin:0 auto;">
                <!-- Logo -->
                <div class="site-branding">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <span class="site-title"><?php bloginfo( 'name' ); ?></span>
                    </a>
                </div>

                <!-- Main Menu -->
                <div class="main-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

                <!-- Right Side Items -->
                <div class="header-actions">
                    <!-- Search -->
                    <div class="header-search">
                        <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                            <input type="search" class="search-field" placeholder="Search for a product or finish" value="<?php echo get_search_query(); ?>" name="s" />
                            <button type="submit" class="search-submit">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="21 21l-4.35-4.35"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Wishlist -->
                    <div class="header-wishlist">
                        <a href="#" class="wishlist-link">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- User Account -->
                    <div class="header-account">
                        <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="account-link">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </a>
                    </div>

                    <!-- Shopping Cart -->
                    <div class="header-cart">
                        <?php if (function_exists('WC')) : ?>
                            <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>
                                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="mobile-menu-toggle">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </nav>
    </header><!-- #masthead -->

<script>
(function() {
    var header = document.getElementById('masthead');
    var ann = document.querySelector('.announcement-bar');
    if (!header) return;

    function getAnnHeight() {
        return ann ? ann.offsetHeight : 0;
    }

    // Position header below announcement bar
    function positionHeader() {
        var ah = getAnnHeight();
        header.style.top = ah + 'px';
        document.body.style.paddingTop = (ah + header.offsetHeight) + 'px';
    }

    function onScroll() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('load', positionHeader);
    window.addEventListener('resize', positionHeader);
    positionHeader();
    onScroll();
})();
</script>