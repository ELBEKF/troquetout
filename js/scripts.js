/**
 * scripts.js — TroqueTout
 * Scripts principaux de l'application.
 *
 * Chargé avec defer depuis base_html.php.
 * Le thème (toggleTheme) est géré en inline dans le <head> — ne pas le mettre ici.
 */

/* =========================================================================
   1. PLUGINS JQUERY (niceSelect, slick, etc.)
   ========================================================================= */
(function ($) {
    'use strict';

    $(document).ready(function () {

        // Initialisation de niceSelect sur tous les <select> sauf .ignore
        if ($.fn.niceSelect) {
            $('select:not(.ignore)').niceSelect();
        }

        // Carousel Slick (seulement si l'élément existe)
        if ($('.category-slider').length && $.fn.slick) {
            $('.category-slider').slick({
                slidesToShow:  8,
                infinite:      true,
                arrows:        false,
                autoplay:      false,
                autoplaySpeed: 2000,
                responsive: [
                    { breakpoint: 1024, settings: { slidesToShow: 5 } },
                    { breakpoint: 768,  settings: { slidesToShow: 3 } },
                    { breakpoint: 480,  settings: { slidesToShow: 2 } }
                ]
            });
        }

        // Lecteur vidéo à la demande
        $('.video-box img').on('click', function () {
            var src   = $(this).attr('data-video');
            var video = '<iframe allowfullscreen src="' + src + '"></iframe>';
            $(this).replaceWith(video);
        });

        // Coupon types
        $('.coupon-types li').on('click', function () {
            $('.coupon-types li').not(this).removeClass('active');
            $(this).addClass('active');
        });

        // Coupon code input toggle
        $('#online-code').on('click', function () {
            $('.code-input').fadeIn(500);
        });
        $('#store-coupon, #online-sale').on('click', function () {
            $('.code-input').fadeOut(500);
        });

        // Tooltips Bootstrap 4 (si disponible)
        if ($.fn.tooltip) {
            $('[data-toggle="tooltip"]').tooltip();
        }

    });

})(jQuery);


/* =========================================================================
   2. BOOTSTRAP 5 — Carousels
   ========================================================================= */
document.addEventListener('DOMContentLoaded', function () {
    if (typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
        document.querySelectorAll('.carousel').forEach(function (el) {
            new bootstrap.Carousel(el, { interval: 5000, ride: 'carousel' });
        });
    }
});


/* =========================================================================
   3. NAVIGATION — Menu mobile & dropdown utilisateur
   ========================================================================= */
document.addEventListener('DOMContentLoaded', function () {

    /* ── Menu mobile ───────────────────────────────────────────────────── */
    var mobileBtn = document.getElementById('mobile-menu-button');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var menu      = document.getElementById('mobile-menu');
            var openIcon  = document.getElementById('menu-open-icon');
            var closeIcon = document.getElementById('menu-close-icon');
            var isOpen    = menu && !menu.classList.contains('hidden');

            if (menu)      menu.classList.toggle('hidden');
            if (openIcon)  openIcon.classList.toggle('hidden');
            if (closeIcon) closeIcon.classList.toggle('hidden');
            mobileBtn.setAttribute('aria-expanded', String(!isOpen));
        });
    }

    /* ── Dropdown utilisateur ──────────────────────────────────────────── */
    var userBtn = document.getElementById('user-menu-button');
    if (userBtn) {
        userBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var menu = document.getElementById('user-menu');
            if (menu) menu.classList.toggle('hidden');
        });
    }

    /* ── Fermer les menus au clic extérieur ────────────────────────────── */
    document.addEventListener('click', function (e) {
        // Dropdown utilisateur
        var userBtn  = document.getElementById('user-menu-button');
        var userMenu = document.getElementById('user-menu');
        if (userBtn && userMenu &&
            !userBtn.contains(e.target) &&
            !userMenu.contains(e.target)) {
            userMenu.classList.add('hidden');
        }
    });

    /* ── Fermer le menu mobile sur clic d'un lien ──────────────────────── */
    document.querySelectorAll('.mobile-nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            var menu      = document.getElementById('mobile-menu');
            var openIcon  = document.getElementById('menu-open-icon');
            var closeIcon = document.getElementById('menu-close-icon');
            var btn       = document.getElementById('mobile-menu-button');

            if (menu)      menu.classList.add('hidden');
            if (openIcon)  openIcon.classList.remove('hidden');
            if (closeIcon) closeIcon.classList.add('hidden');
            if (btn)       btn.setAttribute('aria-expanded', 'false');
        });
    });

});


/* =========================================================================
   4. GOOGLE MAPS — Initialisé uniquement si l'API est chargée
   ========================================================================= */
window.marker = null;

function initGoogleMap() {
    var mapEl = document.getElementById('map');
    if (!mapEl) return; // Ne rien faire si la page n'a pas de carte

    var center = new google.maps.LatLng(51.507351, -0.127758);

    var style = [{
        stylers: [
            { hue: '#ff61a6' },
            { visibility: 'on' },
            { invert_lightness: true },
            { saturation: 40 },
            { lightness: 10 }
        ]
    }];

    var map = new google.maps.Map(mapEl, {
        center:                center,
        mapTypeId:             google.maps.MapTypeId.ROADMAP,
        zoom:                  17,
        backgroundColor:       '#000',
        panControl:            false,
        zoomControl:           true,
        mapTypeControl:        false,
        scaleControl:          false,
        streetViewControl:     false,
        overviewMapControl:    false,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE
        }
    });

    var mapType = new google.maps.StyledMapType(style, { name: 'Grayscale' });
    map.mapTypes.set('grey', mapType);
    map.setMapTypeId('grey');

    var pinIcon = new google.maps.MarkerImage(
        'plugins/google-map/images/marker.png',
        null, null, null,
        new google.maps.Size(74, 73)
    );

    window.marker = new google.maps.Marker({
        position: center,
        map:      map,
        icon:     pinIcon,
        title:    'TroqueTout'
    });
}

// N'écouter l'événement Google Maps que si l'API est présente
if (typeof google !== 'undefined' && google.maps) {
    google.maps.event.addDomListener(window, 'load', initGoogleMap);
}