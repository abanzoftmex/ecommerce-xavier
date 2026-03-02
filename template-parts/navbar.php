<?php
/**
 * Navbar Component — Reusable across all pages.
 * Include via: get_template_part( 'template-parts/navbar' );
 *
 * @package Astra Child
 */

$shop_url = function_exists( 'wc_get_page_id' )
    ? get_permalink( wc_get_page_id( 'shop' ) )
    : home_url( '/shop/' );

$account_url = function_exists( 'wc_get_page_id' )
    ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) )
    : home_url( '/my-account/' );

$cart_url = function_exists( 'wc_get_cart_url' )
    ? wc_get_cart_url()
    : home_url( '/cart/' );
?>

<!-- Announcement Bar -->
<div id="announcementBar" style="background:#1a1a1a;color:#fff;text-align:center;padding:10px 20px;font-size:13px;letter-spacing:0.5px;font-family:'Jost',sans-serif;position:fixed;top:0;left:0;right:0;z-index:1001;">
    Aprovecha nuestro código al realizar tu compra en línea: Code <a href="<?php echo esc_url( $shop_url ); ?>" style="color:#fff;font-weight:600;text-decoration:underline;"><strong>HEY20</strong></a>
</div>

<!-- Main Header -->
<header id="xavierHeader" style="position:fixed;top:0;left:0;right:0;z-index:1000;background:transparent;border-bottom:1px solid rgba(255,255,255,0.1);transition:background 0.35s ease,border-color 0.35s ease,box-shadow 0.35s ease;">
    <nav style="display:flex;align-items:center;justify-content:space-between;padding:16px 40px;max-width:1440px;margin:0 auto;gap:24px;">

        <!-- Logo -->
        <div style="flex-shrink:0;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="text-decoration:none;display:flex;align-items:center;" class="xavier-logo">
                <img src="<?php echo esc_url( content_url( 'uploads/2026/03/cropped-logo_light.webp' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" style="height:40px;width:auto;transition:opacity 0.35s ease;" />
            </a>
        </div>

        <!-- Main Menu -->
        <div style="flex:1;display:flex;justify-content:center;" class="xavier-menu-wrap">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_id'        => 'xavier-primary-menu',
                'menu_class'     => 'xavier-nav-menu',
                'container'      => false,
                'fallback_cb'    => false,
                'walker'         => new Xavier_Catalog_Walker(),
                'items_wrap'     => '<ul id="%1$s" class="%2$s" style="display:flex;list-style:none;margin:0;padding:0;gap:28px;flex-wrap:nowrap;">%3$s</ul>',
            ) );
            ?>
        </div>

        <!-- Right Side Actions -->
        <div style="display:flex;align-items:center;gap:16px;flex-shrink:0;" class="xavier-header-actions">
            <!-- Search -->
            <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display:flex;align-items:center;background:rgba(0,0,0,0.05);padding:7px 14px;border-radius:20px;max-width:220px;transition:background 0.35s ease;" class="xavier-search-form">
                <input type="search" placeholder="Buscador" value="<?php echo get_search_query(); ?>" name="s" style="border:none;background:transparent;outline:none;flex:1;font-size:12px;color:#555;font-family:'Jost',sans-serif;min-width:120px;transition:color 0.35s ease;" class="xavier-search-input" />
                <input type="hidden" name="post_type" value="product" />
                <button type="submit" style="border:none;background:transparent;cursor:pointer;padding:0;color:#666;transition:color 0.35s ease;" class="xavier-search-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>

            <!-- Wishlist -->
            <a href="#" style="color:#1a1a1a;text-decoration:none;display:flex;align-items:center;transition:color 0.35s ease,opacity 0.2s;" class="xavier-icon-link">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
            </a>

            <!-- Account -->
            <a href="<?php echo esc_url( $account_url ); ?>" style="color:#1a1a1a;text-decoration:none;display:flex;align-items:center;transition:color 0.35s ease,opacity 0.2s;" class="xavier-icon-link">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </a>

            <!-- Cart -->
            <?php if ( function_exists( 'WC' ) ) : ?>
            <a href="<?php echo esc_url( $cart_url ); ?>" style="color:#1a1a1a;text-decoration:none;display:flex;align-items:center;position:relative;transition:color 0.35s ease,opacity 0.2s;" class="xavier-icon-link xavier-cart-link">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>
                    <span class="cart-count" style="position:absolute;top:-6px;right:-8px;background:#c8a951;color:#fff;border-radius:50%;width:16px;height:16px;font-size:10px;display:flex;align-items:center;justify-content:center;font-family:'Jost',sans-serif;"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                <?php endif; ?>
            </a>
            <?php endif; ?>
        </div>

    </nav>
</header>

<!-- Navbar Scroll Script -->
<script>
(function() {
    var header = document.getElementById('xavierHeader');
    var ann = document.getElementById('announcementBar');
    if (!header) return;

    function positionHeader() {
        var annH = ann ? ann.offsetHeight : 0;
        header.style.top = annH + 'px';
        document.body.style.paddingTop = (annH + header.offsetHeight) + 'px';
    }

    function onScroll() {
        if (window.scrollY > 50) {
            header.style.background = '#1a1a1a';
            header.style.borderBottomColor = '#333';
            header.style.boxShadow = '0 2px 12px rgba(0,0,0,0.15)';
            // Switch all text/icons to white (exclude dropdown links)
            header.querySelectorAll('.xavier-logo').forEach(function(el) { el.style.color = '#fff'; });
            header.querySelectorAll('.xavier-nav-menu > li > a').forEach(function(el) { el.style.color = 'rgba(255,255,255,0.85)'; });
            header.querySelectorAll('.xavier-icon-link').forEach(function(el) { el.style.color = '#fff'; });
            header.querySelectorAll('.xavier-search-form').forEach(function(el) { el.style.background = 'rgba(255,255,255,0.12)'; });
            header.querySelectorAll('.xavier-search-input').forEach(function(el) { el.style.color = '#fff'; });
            header.querySelectorAll('.xavier-search-btn').forEach(function(el) { el.style.color = 'rgba(255,255,255,0.7)'; });
        } else {
            header.style.background = 'transparent';
            header.style.borderBottomColor = 'rgba(255,255,255,0.1)';
            header.style.boxShadow = 'none';
            // Switch back to dark (exclude dropdown links)
            header.querySelectorAll('.xavier-logo').forEach(function(el) { el.style.color = '#1a1a1a'; });
            header.querySelectorAll('.xavier-nav-menu > li > a').forEach(function(el) { el.style.color = '#1a1a1a'; });
            header.querySelectorAll('.xavier-icon-link').forEach(function(el) { el.style.color = '#1a1a1a'; });
            header.querySelectorAll('.xavier-search-form').forEach(function(el) { el.style.background = 'rgba(0,0,0,0.05)'; });
            header.querySelectorAll('.xavier-search-input').forEach(function(el) { el.style.color = '#555'; });
            header.querySelectorAll('.xavier-search-btn').forEach(function(el) { el.style.color = '#666'; });
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('load', positionHeader);
    window.addEventListener('resize', positionHeader);
    positionHeader();
    onScroll();

    // ── Catalog dropdown hover (inline-style to beat Astra specificity) ──
    function xvDropdownHide(panel) {
        panel.style.setProperty('opacity',     '0',       'important');
        panel.style.setProperty('visibility',  'hidden',  'important');
        panel.style.setProperty('pointer-events', 'none', 'important');
        panel.style.setProperty('transform',   'translateX(-50%) translateY(6px)', 'important');
    }
    function xvDropdownShow(panel) {
        panel.style.setProperty('opacity',     '1',       'important');
        panel.style.setProperty('visibility',  'visible', 'important');
        panel.style.setProperty('pointer-events', 'auto', 'important');
        panel.style.setProperty('transform',   'translateX(-50%) translateY(0)',   'important');
    }
    document.querySelectorAll('.xv-has-dropdown').forEach(function(li) {
        var panel = li.querySelector('.xv-catalog-dropdown');
        if (!panel) return;
        xvDropdownHide(panel);                              // init hidden
        li.addEventListener('mouseenter', function() { xvDropdownShow(panel); });
        li.addEventListener('mouseleave', function() { xvDropdownHide(panel); });
    });

    // Style menu items inline (override Astra)
    header.querySelectorAll('.xavier-nav-menu li').forEach(function(li) {
        li.style.margin = '0';
        li.style.padding = '0';
        li.style.listStyle = 'none';
        li.style.whiteSpace = 'nowrap';
    });
    header.querySelectorAll('.xavier-nav-menu > li > a').forEach(function(a) {
        a.style.textDecoration = 'none';
        a.style.fontFamily = "'Jost', sans-serif";
        a.style.fontSize = '13px';
        a.style.fontWeight = '400';
        a.style.letterSpacing = '0.3px';
        a.style.transition = 'color 0.35s ease';
    });
})();
</script>
