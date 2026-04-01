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

$wishlist_url   = add_query_arg( 'xv_favorites', '1', $shop_url );
$wishlist_count = function_exists( 'astra_child_get_favorite_ids_from_cookie' )
    ? count( astra_child_get_favorite_ids_from_cookie() )
    : 0;
?>

<!-- Announcement Bar -->
<div id="announcementBar" style="background:#1a1a1a;color:#fff;text-align:center;padding:10px 20px;font-size:13px;letter-spacing:0.5px;font-family:'Jost',sans-serif;position:fixed;top:0;left:0;right:0;z-index:1001;">
    Aprovecha nuestro código al realizar tu compra en línea: Code <a href="<?php echo esc_url( $shop_url ); ?>" style="color:#fff;font-weight:600;text-decoration:underline;"><strong>HEY20</strong></a>
</div>

<!-- Main Header -->
<header id="xavierHeader" style="position:fixed;top:0;left:0;right:0;z-index:1000;background:transparent;border-bottom:1px solid rgba(255,255,255,0.1);transition:background 0.35s ease,border-color 0.35s ease,box-shadow 0.35s ease;">
    <nav style="display:flex;align-items:center;justify-content:space-between;padding:14px 40px 18px;max-width:1440px;margin:0 auto;gap:24px;">

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
            <a href="<?php echo esc_url( $wishlist_url ); ?>" style="color:#1a1a1a;text-decoration:none;display:flex;align-items:center;position:relative;transition:color 0.35s ease,opacity 0.2s;" class="xavier-icon-link xavier-wishlist-link" aria-label="Ver favoritos">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span class="xv-wishlist-count" style="position:absolute;top:-6px;right:-8px;background:#c8a951;color:#fff;border-radius:50%;width:16px;height:16px;font-size:10px;display:<?php echo $wishlist_count > 0 ? 'flex' : 'none'; ?>;align-items:center;justify-content:center;font-family:'Jost',sans-serif;"><?php echo esc_html( $wishlist_count ); ?></span>
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
                <?php $header_cart_count = WC()->cart->get_cart_contents_count(); ?>
                <span class="cart-count" style="position:absolute;top:-6px;right:-8px;background:#c8a951;color:#fff;border-radius:50%;width:16px;height:16px;font-size:10px;display:<?php echo $header_cart_count > 0 ? 'flex' : 'none'; ?>;align-items:center;justify-content:center;font-family:'Jost',sans-serif;"><?php echo esc_html( $header_cart_count ); ?></span>
            </a>
            <?php endif; ?>

            <button type="button" class="xavier-mobile-toggle" aria-label="Abrir menu" aria-expanded="false" aria-controls="xvMobileMenu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

    </nav>
</header>

<div id="xvMobileMenuOverlay" class="xv-mobile-menu-overlay" aria-hidden="true"></div>

<aside id="xvMobileMenu" class="xv-mobile-menu" aria-hidden="true" aria-label="Menu mobile">
    <div class="xv-mobile-menu__header">
        <p>Menu</p>
        <button type="button" class="xv-mobile-menu__close" aria-label="Cerrar menu">×</button>
    </div>

    <nav class="xv-mobile-menu__nav" aria-label="Menu principal mobile">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_id'        => 'xavier-mobile-menu',
            'menu_class'     => 'xv-mobile-nav-menu',
            'container'      => false,
            'fallback_cb'    => false,
            'depth'          => 1,
        ) );
        ?>
    </nav>

    <div class="xv-mobile-menu__links">
        <a href="<?php echo esc_url( $wishlist_url ); ?>">Favoritos</a>
        <a href="<?php echo esc_url( $account_url ); ?>">Mi cuenta</a>
        <a href="<?php echo esc_url( $cart_url ); ?>">Carrito</a>
    </div>
</aside>

<?php if ( function_exists( 'WC' ) ) : ?>
<div id="xvCartDrawerOverlay" class="xv-cart-drawer-overlay" aria-hidden="true"></div>

<aside id="xvCartDrawer" class="xv-cart-drawer" aria-hidden="true" aria-label="Carrito lateral">
    <div class="xv-cart-drawer__header">
        <p class="xv-cart-drawer__kicker">Seleccion actual</p>
        <h3>Carrito</h3>
        <button type="button" class="xv-cart-drawer__close" aria-label="Cerrar carrito">×</button>
    </div>

    <div class="xv-cart-drawer__body">
        <div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div>
    </div>
</aside>
<?php endif; ?>

<!-- Navbar Scroll Script -->
<script>
(function() {
    var header = document.getElementById('xavierHeader');
    var ann = document.getElementById('announcementBar');
    var mobileToggle = document.querySelector('.xavier-mobile-toggle');
    var mobileMenu = document.getElementById('xvMobileMenu');
    var mobileMenuOverlay = document.getElementById('xvMobileMenuOverlay');
    var mobileMenuClose = mobileMenu ? mobileMenu.querySelector('.xv-mobile-menu__close') : null;
    var cartLink = document.querySelector('.xavier-cart-link');
    var cartDrawer = document.getElementById('xvCartDrawer');
    var cartDrawerOverlay = document.getElementById('xvCartDrawerOverlay');
    var cartDrawerClose = cartDrawer ? cartDrawer.querySelector('.xv-cart-drawer__close') : null;
    if (!header) return;

    function positionHeader() {
        var annH = ann ? ann.offsetHeight : 0;
        var headerH = header.offsetHeight;
        var offset = annH + headerH;
        var visualGap = 12;
        var visualOffset = offset + visualGap;

        if (document.body.classList.contains('home') || document.body.classList.contains('front-page')) {
            visualOffset = offset + 8;
        }

        header.style.top = annH + 'px';
        document.body.style.paddingTop = visualOffset + 'px';
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
            header.querySelectorAll('.xavier-mobile-toggle span').forEach(function(el) { el.style.background = '#fff'; });
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
            header.querySelectorAll('.xavier-mobile-toggle span').forEach(function(el) { el.style.background = '#1a1a1a'; });
        }
    }

    function openMobileMenu() {
        if (!mobileMenu || !mobileMenuOverlay || !mobileToggle) return;
        mobileMenu.classList.add('is-open');
        mobileMenuOverlay.classList.add('is-open');
        mobileMenu.setAttribute('aria-hidden', 'false');
        mobileMenuOverlay.setAttribute('aria-hidden', 'false');
        mobileToggle.setAttribute('aria-expanded', 'true');
        document.body.classList.add('xv-mobile-menu-open');
    }

    function closeMobileMenu() {
        if (!mobileMenu || !mobileMenuOverlay || !mobileToggle) return;
        mobileMenu.classList.remove('is-open');
        mobileMenuOverlay.classList.remove('is-open');
        mobileMenu.setAttribute('aria-hidden', 'true');
        mobileMenuOverlay.setAttribute('aria-hidden', 'true');
        mobileToggle.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('xv-mobile-menu-open');
    }

    function openCartDrawer() {
        if (!cartDrawer || !cartDrawerOverlay) return;
        cartDrawer.classList.add('is-open');
        cartDrawerOverlay.classList.add('is-open');
        cartDrawer.setAttribute('aria-hidden', 'false');
        cartDrawerOverlay.setAttribute('aria-hidden', 'false');
        document.body.classList.add('xv-drawer-open');
    }

    function closeCartDrawer() {
        if (!cartDrawer || !cartDrawerOverlay) return;
        cartDrawer.classList.remove('is-open');
        cartDrawerOverlay.classList.remove('is-open');
        cartDrawer.setAttribute('aria-hidden', 'true');
        cartDrawerOverlay.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('xv-drawer-open');
    }

    function refreshCartCountFromDOM() {
        if (!cartLink) return;

        var countEl = cartLink.querySelector('.cart-count');
        if (!countEl) return;

        var qtyNodes = document.querySelectorAll('#xvCartDrawer .woocommerce-mini-cart-item .quantity');
        var totalCount = 0;

        qtyNodes.forEach(function(node) {
            var text = (node.textContent || '').trim();
            var match = text.match(/^(\d+)\s*[×x]/);
            if (match && match[1]) {
                totalCount += parseInt(match[1], 10);
            } else if (text) {
                totalCount += 1;
            }
        });

        countEl.textContent = String(totalCount);
        countEl.style.display = totalCount > 0 ? 'flex' : 'none';
    }

    function applyWooFragments(fragments) {
        if (!fragments) return;
        Object.keys(fragments).forEach(function(selector) {
            var html = fragments[selector];
            document.querySelectorAll(selector).forEach(function(node) {
                node.outerHTML = html;
            });
        });
        refreshCartCountFromDOM();
    }

    function getAjaxAddToCartUrl() {
        if (window.wc_add_to_cart_params && window.wc_add_to_cart_params.wc_ajax_url) {
            return window.wc_add_to_cart_params.wc_ajax_url.replace('%%endpoint%%', 'add_to_cart');
        }
        return window.location.origin + '/?wc-ajax=add_to_cart';
    }

    function getFormProductId(form) {
        var hidden = form.querySelector('input[name="add-to-cart"]');
        if (hidden && hidden.value) {
            return parseInt(hidden.value, 10);
        }

        var button = form.querySelector('button[name="add-to-cart"][value]');
        if (button && button.value) {
            return parseInt(button.value, 10);
        }

        return 0;
    }

    function ajaxAddToCart(form) {
        var productId = getFormProductId(form);
        if (!productId) return false;

        // Let WooCommerce handle variable/grouped products with its own flow.
        if (form.querySelector('input[name="variation_id"]')) {
            return false;
        }

        var quantityInput = form.querySelector('[name="quantity"]');
        var quantity = quantityInput ? parseInt(quantityInput.value, 10) : 1;
        if (!quantity || quantity < 1) quantity = 1;

        var payload = new URLSearchParams();
        payload.set('product_id', String(productId));
        payload.set('quantity', String(quantity));

        fetch(getAjaxAddToCartUrl(), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: payload.toString(),
            credentials: 'same-origin'
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (!data || data.error) {
                form.submit();
                return;
            }

            applyWooFragments(data.fragments || {});
            openCartDrawer();

            if (window.jQuery) {
                window.jQuery(document.body).trigger('added_to_cart', [data.fragments, data.cart_hash]);
            }
        })
        .catch(function() {
            form.submit();
        });

        return true;
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('load', positionHeader);
    window.addEventListener('resize', positionHeader);
    positionHeader();
    onScroll();

    if (cartLink) {
        cartLink.addEventListener('click', function(event) {
            event.preventDefault();
            closeMobileMenu();
            openCartDrawer();
        });
    }

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            if (mobileMenu && mobileMenu.classList.contains('is-open')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
    }

    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', closeMobileMenu);
    }

    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }

    if (mobileMenu) {
        mobileMenu.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', closeMobileMenu);
        });
    }

    if (cartDrawerOverlay) {
        cartDrawerOverlay.addEventListener('click', closeCartDrawer);
    }

    if (cartDrawerClose) {
        cartDrawerClose.addEventListener('click', closeCartDrawer);
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeMobileMenu();
            closeCartDrawer();
        }
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 980) {
            closeMobileMenu();
        }
    });

    document.addEventListener('submit', function(event) {
        var form = event.target;
        if (!form || form.tagName !== 'FORM') return;

        var hasQuickAdd = !!form.querySelector('.xv-quick-add');
        var hasSingleAdd = !!form.querySelector('#xvAddToCart');
        if (!hasQuickAdd && !hasSingleAdd) return;

        if (ajaxAddToCart(form)) {
            event.preventDefault();
        }
    });

    var params = new URLSearchParams(window.location.search);
    if (params.has('add-to-cart') || params.has('added-to-cart')) {
        openCartDrawer();
    }

    if (window.jQuery) {
        window.jQuery(document.body).on('added_to_cart', function(event, fragments) {
            applyWooFragments(fragments || {});
            openCartDrawer();
        });
    }

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
    // ── Mega-menu: all critical styles via setProperty (inline !important) ──
    var GOLD  = '#c8a951';
    var DARK  = '#1a1a1a';
    var WHITE = '#ffffff';

    function xvApplyLinkStyles(panel) {
        // Force all megamenu styles via JavaScript to override Astra
        
        // Style the container
        var inner = panel.querySelector('.xv-megamenu__inner');
        if (inner) {
            inner.style.setProperty('width', '100%', 'important');
            inner.style.setProperty('margin', '0', 'important');
            inner.style.setProperty('padding', '40px', 'important');
            inner.style.setProperty('display', 'flex', 'important');
            inner.style.setProperty('flex-direction', 'column', 'important');
            inner.style.setProperty('align-items', 'center', 'important');
            inner.style.setProperty('text-align', 'center', 'important');
        }
        
        // Style the header
        var header = panel.querySelector('.xv-megamenu__header');
        if (header) {
            header.style.setProperty('text-align', 'center', 'important');
            header.style.setProperty('margin-bottom', '30px', 'important');
        }
        
        var title = panel.querySelector('.xv-megamenu__title');
        if (title) {
            title.style.setProperty('font-family', 'Jost, sans-serif', 'important');
            title.style.setProperty('font-size', '24px', 'important');
            title.style.setProperty('font-weight', '600', 'important');
            title.style.setProperty('color', '#1a1a1a', 'important');
            title.style.setProperty('margin', '0 0 8px 0', 'important');
            title.style.setProperty('text-decoration', 'none', 'important');
        }
        
        var subtitle = panel.querySelector('.xv-megamenu__subtitle');
        if (subtitle) {
            subtitle.style.setProperty('font-family', 'Jost, sans-serif', 'important');
            subtitle.style.setProperty('font-size', '14px', 'important');
            subtitle.style.setProperty('color', '#666', 'important');
            subtitle.style.setProperty('margin', '0', 'important');
        }
        
        // Style the list
        var list = panel.querySelector('.xv-megamenu__list');
        if (list) {
            list.style.setProperty('list-style', 'none', 'important');
            list.style.setProperty('margin', '0 0 30px 0', 'important');
            list.style.setProperty('padding', '0', 'important');
            list.style.setProperty('display', 'flex', 'important');
            list.style.setProperty('flex-wrap', 'wrap', 'important');
            list.style.setProperty('justify-content', 'center', 'important');
            list.style.setProperty('gap', '12px', 'important');
            list.style.setProperty('width', '100%', 'important');
        }
        
        // Style each category link
        panel.querySelectorAll('.xv-megamenu__link').forEach(function(a) {
            // Base styles
            a.style.setProperty('display', 'inline-block', 'important');
            a.style.setProperty('font-family', 'Jost, sans-serif', 'important');
            a.style.setProperty('font-size', '15px', 'important');
            a.style.setProperty('font-weight', '500', 'important');
            a.style.setProperty('text-decoration', 'none', 'important');
            a.style.setProperty('padding', '12px 20px', 'important');
            a.style.setProperty('border', '2px solid #f0f0f0', 'important');
            a.style.setProperty('border-radius', '25px', 'important');
            a.style.setProperty('color', '#333', 'important');
            a.style.setProperty('background', '#fafafa', 'important');
            a.style.setProperty('transition', 'all 0.3s ease', 'important');
            a.style.setProperty('white-space', 'nowrap', 'important');
            a.style.setProperty('-webkit-text-fill-color', '#333', 'important');
            a.style.setProperty('box-shadow', 'none', 'important');
            a.style.setProperty('transform', 'none', 'important');
            
            // Hover events
            a.addEventListener('mouseenter', function() {
                this.style.setProperty('border-color', '#c8a951', 'important');
                this.style.setProperty('background', '#c8a951', 'important');
                this.style.setProperty('color', 'white', 'important');
                this.style.setProperty('-webkit-text-fill-color', 'white', 'important');
                this.style.setProperty('transform', 'translateY(-2px)', 'important');
                this.style.setProperty('box-shadow', '0 5px 15px rgba(200, 169, 81, 0.3)', 'important');
            });
            
            a.addEventListener('mouseleave', function() {
                this.style.setProperty('border-color', '#f0f0f0', 'important');
                this.style.setProperty('background', '#fafafa', 'important');
                this.style.setProperty('color', '#333', 'important');
                this.style.setProperty('-webkit-text-fill-color', '#333', 'important');
                this.style.setProperty('transform', 'none', 'important');
                this.style.setProperty('box-shadow', 'none', 'important');
            });
        });
        
        // Style the "Ver todo" button
        var allLink = panel.querySelector('.xv-megamenu__all');
        if (allLink) {
            allLink.style.setProperty('display', 'inline-block', 'important');
            allLink.style.setProperty('font-family', 'Jost, sans-serif', 'important');
            allLink.style.setProperty('font-size', '14px', 'important');
            allLink.style.setProperty('font-weight', '600', 'important');
            allLink.style.setProperty('letter-spacing', '0.5px', 'important');
            allLink.style.setProperty('text-transform', 'uppercase', 'important');
            allLink.style.setProperty('text-decoration', 'none', 'important');
            allLink.style.setProperty('padding', '15px 30px', 'important');
            allLink.style.setProperty('margin', '0', 'important');
            allLink.style.setProperty('border', '2px solid #c8a951', 'important');
            allLink.style.setProperty('border-radius', '30px', 'important');
            allLink.style.setProperty('background', '#c8a951', 'important');
            allLink.style.setProperty('color', 'white', 'important');
            allLink.style.setProperty('-webkit-text-fill-color', 'white', 'important');
            allLink.style.setProperty('transition', 'all 0.3s ease', 'important');
            allLink.style.setProperty('box-shadow', 'none', 'important');
            allLink.style.setProperty('transform', 'none', 'important');
            
            allLink.addEventListener('mouseenter', function() {
                this.style.setProperty('background', 'white', 'important');
                this.style.setProperty('color', '#c8a951', 'important');
                this.style.setProperty('-webkit-text-fill-color', '#c8a951', 'important');
                this.style.setProperty('transform', 'translateY(-2px)', 'important');
                this.style.setProperty('box-shadow', '0 5px 15px rgba(200, 169, 81, 0.3)', 'important');
            });
            
            allLink.addEventListener('mouseleave', function() {
                this.style.setProperty('background', '#c8a951', 'important');
                this.style.setProperty('color', 'white', 'important');
                this.style.setProperty('-webkit-text-fill-color', 'white', 'important');
                this.style.setProperty('transform', 'none', 'important');
                this.style.setProperty('box-shadow', 'none', 'important');
            });
        }
    }

    function xvMegaInit() {
        var hdr = document.getElementById('xavierHeader');
        document.querySelectorAll('.xv-megamenu').forEach(function(panel) {
            // Apply all layout styles via setProperty so Astra cannot override
            var s = panel.style;
            s.setProperty('display',          'none',  'important');
            s.setProperty('visibility',       'hidden', 'important');
            s.setProperty('opacity',          '0',     'important');
            s.setProperty('position',         'fixed', 'important');
            s.setProperty('left',             '50%',   'important');
            s.setProperty('right',            'auto',  'important');
            s.setProperty('transform',        'translateX(-50%)', 'important');
            s.setProperty('width',            'auto',  'important');
            s.setProperty('min-width',        '600px', 'important');
            s.setProperty('max-width',        '800px', 'important');
            s.setProperty('background',       'white', 'important');
            s.setProperty('background-color', 'white', 'important');
            s.setProperty('border-radius',    '15px',  'important');
            s.setProperty('border',           '1px solid #e5e5e5', 'important');
            s.setProperty('box-shadow',       '0 15px 50px rgba(0, 0, 0, 0.1)', 'important');
            s.setProperty('padding',          '0',     'important');
            s.setProperty('z-index',          '9998',  'important');
            s.setProperty('margin',           '0',     'important');
            
            xvApplyLinkStyles(panel);

            var li = panel.closest('.xv-has-dropdown');
            if (!li) return;

            var hideTimer = null;

            function show() {
                if (hideTimer) clearTimeout(hideTimer);
                if (hdr) {
                    panel.style.setProperty('top', hdr.getBoundingClientRect().bottom + 'px', 'important');
                }
                panel.style.setProperty('display', 'block', 'important');
                panel.style.setProperty('visibility', 'visible', 'important');
                panel.style.setProperty('opacity', '1', 'important');
            }

            function scheduleHide() {
                hideTimer = setTimeout(function() {
                    panel.style.setProperty('display', 'none', 'important');
                    panel.style.setProperty('visibility', 'hidden', 'important');
                    panel.style.setProperty('opacity', '0', 'important');
                }, 250); // Generous delay to bridge any gap
            }

            // Mouse enters trigger or panel -> SHOW
            li.addEventListener('mouseenter', show);
            panel.addEventListener('mouseenter', show);

            // Mouse leaves trigger or panel -> WAIT, THEN HIDE
            li.addEventListener('mouseleave', scheduleHide);
            panel.addEventListener('mouseleave', scheduleHide);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', xvMegaInit);
    } else {
        xvMegaInit();
    }
})();
</script>
