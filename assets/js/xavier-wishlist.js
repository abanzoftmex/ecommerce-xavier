(function () {
    'use strict';

    var config = window.xavierWishlist || {};
    var STORAGE_KEY = config.storageKey || 'xv_favorites';
    var COOKIE_NAME = config.cookieName || 'xv_favorites';
    var FAVORITES_URL = config.favoritesPageUrl || '/shop/?xv_favorites=1';
    var IN_FAVORITES_VIEW = Number(config.inFavoritesView || 0) === 1;

    function normalizeIds(ids) {
        var seen = {};
        var out = [];

        (ids || []).forEach(function (id) {
            var parsed = Number(id);
            if (!Number.isInteger(parsed) || parsed <= 0 || seen[parsed]) {
                return;
            }
            seen[parsed] = true;
            out.push(parsed);
        });

        return out;
    }

    function parseIdsFromString(value) {
        if (!value || typeof value !== 'string') {
            return [];
        }

        var parsed;

        if (value.trim().charAt(0) === '[') {
            try {
                parsed = JSON.parse(value);
            } catch (err) {
                parsed = [];
            }
            return normalizeIds(Array.isArray(parsed) ? parsed : []);
        }

        return normalizeIds(value.split(','));
    }

    function getCookie(name) {
        var search = '; ' + document.cookie;
        var parts = search.split('; ' + name + '=');
        if (parts.length !== 2) {
            return '';
        }
        return decodeURIComponent(parts.pop().split(';').shift());
    }

    function setCookie(name, value, days) {
        var maxAge = days * 24 * 60 * 60;
        document.cookie = name + '=' + encodeURIComponent(value) + '; path=/; max-age=' + maxAge + '; SameSite=Lax';
    }

    function readIds() {
        var localIds = [];
        var cookieIds = parseIdsFromString(getCookie(COOKIE_NAME));

        try {
            localIds = parseIdsFromString(window.localStorage.getItem(STORAGE_KEY) || '');
        } catch (err) {
            localIds = [];
        }

        if (localIds.length === 0 && cookieIds.length > 0) {
            writeIds(cookieIds);
            return cookieIds;
        }

        if (localIds.length > 0) {
            setCookie(COOKIE_NAME, localIds.join(','), 365);
            return localIds;
        }

        return [];
    }

    function writeIds(ids) {
        var cleanIds = normalizeIds(ids);
        var serialized = cleanIds.join(',');

        try {
            window.localStorage.setItem(STORAGE_KEY, serialized);
        } catch (err) {
            // localStorage can fail in private mode; cookie remains the fallback.
        }

        setCookie(COOKIE_NAME, serialized, 365);

        return cleanIds;
    }

    function updateCounter(ids) {
        var count = ids.length;

        document.querySelectorAll('.xv-wishlist-count').forEach(function (counter) {
            counter.textContent = String(count);
            counter.style.display = count > 0 ? 'flex' : 'none';
        });
    }

    function buildFavoritesUrl(ids) {
        var cleanIds = normalizeIds(ids || []);

        try {
            var url = new URL(FAVORITES_URL, window.location.origin);
            url.searchParams.set('xv_favorites', '1');

            if (cleanIds.length > 0) {
                url.searchParams.set('xv_ids', cleanIds.join(','));
            } else {
                url.searchParams.delete('xv_ids');
            }

            // Force a fresh render for personalized favorites pages behind page cache.
            url.searchParams.set('xv_rt', String(Date.now()));

            return url.pathname + url.search + url.hash;
        } catch (err) {
            var idsPart = cleanIds.length > 0 ? '&xv_ids=' + encodeURIComponent(cleanIds.join(',')) : '';
            return FAVORITES_URL + idsPart + '&xv_rt=' + Date.now();
        }
    }

    function updateWishlistLinks(ids) {
        var href = buildFavoritesUrl(ids);

        document.querySelectorAll('.xavier-wishlist-link').forEach(function (link) {
            link.setAttribute('href', href);
        });
    }

    function updateButton(button, ids) {
        var productId = Number(button.getAttribute('data-product-id'));
        if (!Number.isInteger(productId) || productId <= 0) {
            return;
        }

        var isActive = ids.indexOf(productId) !== -1;
        var label = isActive ? 'Quitar de favoritos' : 'Agregar a favoritos';

        button.classList.toggle('is-active', isActive);
        button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        button.setAttribute('aria-label', label);

        var textNode = button.querySelector('[data-favorite-label]');
        if (textNode) {
            textNode.textContent = label;
        }
    }

    function updateButtons(ids) {
        document.querySelectorAll('.xv-favorite-toggle[data-product-id]').forEach(function (button) {
            updateButton(button, ids);
        });
    }

    function ensureFavoritesEmptyState() {
        if (!IN_FAVORITES_VIEW) {
            return;
        }

        var grid = document.getElementById('xvProductGrid');
        if (!grid) {
            return;
        }

        var hasCards = grid.querySelectorAll('[data-favorite-card]').length > 0;
        var emptyState = document.getElementById('xvWishlistInlineEmpty');

        if (hasCards && emptyState) {
            emptyState.remove();
            return;
        }

        if (!hasCards && !emptyState) {
            var message = document.createElement('p');
            message.id = 'xvWishlistInlineEmpty';
            message.className = 'xv-wishlist-empty-inline';
            message.textContent = 'Aun no tienes productos favoritos.';
            grid.parentNode.insertBefore(message, grid.nextSibling);
        }
    }

    function syncUI(ids) {
        updateCounter(ids);
        updateWishlistLinks(ids);
        updateButtons(ids);
        ensureFavoritesEmptyState();
    }

    function toggleFavorite(productId) {
        var ids = readIds();
        var index = ids.indexOf(productId);

        if (index === -1) {
            ids.push(productId);
        } else {
            ids.splice(index, 1);

            if (IN_FAVORITES_VIEW) {
                document.querySelectorAll('[data-favorite-card="' + productId + '"]').forEach(function (card) {
                    card.remove();
                });
            }
        }

        ids = writeIds(ids);
        syncUI(ids);

        document.dispatchEvent(new CustomEvent('xv:wishlistChanged', {
            detail: { ids: ids }
        }));
    }

    function bindEvents() {
        document.addEventListener('click', function (event) {
            var button = event.target.closest('.xv-favorite-toggle[data-product-id]');
            if (!button) {
                return;
            }

            event.preventDefault();

            var productId = Number(button.getAttribute('data-product-id'));
            if (!Number.isInteger(productId) || productId <= 0) {
                return;
            }

            toggleFavorite(productId);
        });

        document.addEventListener('click', function (event) {
            var wishlistLink = event.target.closest('.xavier-wishlist-link');
            if (!wishlistLink) {
                return;
            }

            wishlistLink.setAttribute('href', buildFavoritesUrl(readIds()));
        });

        window.addEventListener('storage', function (event) {
            if (event.key === STORAGE_KEY) {
                syncUI(readIds());
            }
        });
    }

    function init() {
        bindEvents();
        syncUI(readIds());
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
