
'use strict';

window.applyTheme = function (theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
};

window.toggleTheme = function () {
    var current = localStorage.getItem('theme') || 'light';
    window.applyTheme(current === 'light' ? 'dark' : 'light');
};

(function () {
    window.applyTheme(localStorage.getItem('theme') || 'light');
}());

function initConfirmLinks() {
    document.querySelectorAll('a[data-confirm]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            var message = this.getAttribute('data-confirm') || 'Confirmer cette action ?';
            if (!window.confirm(message)) {
                e.preventDefault();
            }
        });
    });
}

function initBackButtons() {
    document.querySelectorAll('[data-action="back"]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            history.back();
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {

    initNavDropdown();
    initMobileMenu();
    initOutsideClick();
    initTabs();
    initAjaxSearch();
    initPhotoPreview();
    initMessaging();
    initScrollUp();

});

function initNavDropdown() {
    var btn  = document.getElementById('user-menu-button');
    var menu = document.getElementById('user-menu');
    if (!btn || !menu) return;

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        var isNowVisible = !menu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', isNowVisible ? 'true' : 'false');
    });
}


function initMobileMenu() {
    var btn       = document.getElementById('mobile-menu-button');
    var menu      = document.getElementById('mobile-menu');
    var iconOpen  = document.getElementById('menu-open-icon');
    var iconClose = document.getElementById('menu-close-icon');
    if (!btn || !menu) return;

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        var isNowVisible = !menu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', isNowVisible ? 'true' : 'false');
        if (iconOpen)  iconOpen.classList.toggle('hidden');
        if (iconClose) iconClose.classList.toggle('hidden');
    });
}


function initOutsideClick() {
    document.addEventListener('click', function () {

        var userMenu = document.getElementById('user-menu');
        var userBtn  = document.getElementById('user-menu-button');
        if (userMenu && !userMenu.classList.contains('hidden')) {
            userMenu.classList.add('hidden');
            if (userBtn) userBtn.setAttribute('aria-expanded', 'false');
        }

        var mobileMenu = document.getElementById('mobile-menu');
        var mobileBtn  = document.getElementById('mobile-menu-button');
        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            if (mobileBtn) mobileBtn.setAttribute('aria-expanded', 'false');
            var iconOpen  = document.getElementById('menu-open-icon');
            var iconClose = document.getElementById('menu-close-icon');
            if (iconOpen)  iconOpen.classList.remove('hidden');
            if (iconClose) iconClose.classList.add('hidden');
        }

    });
}


function initTabs() {
    var buttons = document.querySelectorAll('.tab-button[data-tab]');
    if (!buttons.length) return;

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetId = btn.getAttribute('data-tab');

            buttons.forEach(function (b) {
                b.classList.remove('active', 'btn-primary');
                b.classList.add('btn-outline-primary');
                b.setAttribute('aria-selected', 'false');
            });
            btn.classList.add('active', 'btn-primary');
            btn.classList.remove('btn-outline-primary');
            btn.setAttribute('aria-selected', 'true');

            document.querySelectorAll('.tab-content').forEach(function (panel) {
                panel.classList.add('hidden');
                panel.classList.remove('active');
            });
            var target = document.getElementById(targetId);
            if (target) {
                target.classList.remove('hidden');
                target.classList.add('active');
            }
        });
    });
}

function initAjaxSearch() {
    var form        = document.getElementById('search-form');
    var offersGrid  = document.getElementById('offers-grid');
    var offersCount = document.getElementById('offers-count');
    if (!form || !offersGrid) return;

    var debounceTimer;

    function debounce(fn, delay) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fn, delay);
    }

    function showLoader() {
        offersGrid.innerHTML =
            '<div class="text-center py-5" role="status" aria-live="polite">' +
                '<div class="spinner-border text-primary mb-3" aria-hidden="true"></div>' +
                '<p class="text-muted">Recherche en cours\u2026</p>' +
            '</div>';
    }

    function updateCount(count) {
        if (offersCount) {
            offersCount.textContent = count + ' annonce' + (count > 1 ? 's' : '');
        }
    }

    function fetchOffers() {
        var params = new URLSearchParams(new FormData(form)).toString();
        showLoader();

        fetch('/?' + params, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.text();
            })
            .then(function (html) {
                offersGrid.innerHTML = html;
                updateCount(offersGrid.querySelectorAll('article').length);
            })
            .catch(function () {
                offersGrid.innerHTML =
                    '<div class="alert alert-danger text-center shadow-sm" role="alert">' +
                        '<i class="bi bi-wifi-off me-2" aria-hidden="true"></i>' +
                        'Une erreur est survenue. Veuillez r\u00e9essayer.' +
                    '</div>';
            });
    }

    var searchEl = document.getElementById('search');
    if (searchEl) {
        searchEl.addEventListener('input', function () { debounce(fetchOffers, 400); });
    }

    var locEl = document.getElementById('localisation');
    if (locEl) {
        locEl.addEventListener('input', function () { debounce(fetchOffers, 500); });
    }

    form.querySelectorAll('select').forEach(function (sel) {
        sel.addEventListener('change', fetchOffers);
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        fetchOffers();
    });
}

function initPhotoPreview() {
    var input     = document.getElementById('photo');
    var container = document.getElementById('preview-container');
    var img       = document.getElementById('preview-img');
    if (!input || !container || !img) return;

    input.addEventListener('change', function () {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                container.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            container.classList.add('d-none');
        }
    });
}


function initMessaging() {

    document.querySelectorAll('.message-preview[data-target]').forEach(function (preview) {

        preview.addEventListener('click', function () {
            var details  = document.getElementById(preview.getAttribute('data-target'));
            var icon     = preview.querySelector('.expand-icon');
            if (!details) return;

            var isOpening = details.classList.contains('msg-body-hidden');
            details.classList.toggle('msg-body-hidden', !isOpening);
            preview.setAttribute('aria-expanded', isOpening ? 'true' : 'false');

            if (icon) {
                icon.style.transform  = isOpening ? 'rotate(180deg)' : 'rotate(0deg)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });

        preview.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                preview.click();
            }
        });
    });

    document.querySelectorAll('.reply-btn[data-reply-target]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var form = document.getElementById(btn.getAttribute('data-reply-target'));
            if (!form) return;
            form.classList.remove('msg-body-hidden');
            btn.classList.add('d-none');
        });
    });

    document.querySelectorAll('.cancel-reply-btn[data-reply-id]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var replyId   = btn.getAttribute('data-reply-id');
            var replyForm = document.getElementById(replyId);
            if (replyForm) replyForm.classList.add('msg-body-hidden');

            var replyBtn = document.querySelector('.reply-btn[data-reply-target="' + replyId + '"]');
            if (replyBtn) replyBtn.classList.remove('d-none');
        });
    });
}


function initScrollUp() {
    var btn = document.getElementById('scrollUp');
    if (!btn) return;

    window.addEventListener('scroll', function () {
        btn.classList.toggle('d-none', window.scrollY < 300);
    }, { passive: true });
}
(function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();   