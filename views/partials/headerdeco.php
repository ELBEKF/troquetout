<!-- ✅ Header visiteurs non connectés — HTML valide et sémantique -->
<header class="header modern-nav" role="banner">
    <nav class="nav-container" aria-label="Navigation principale">
        <div class="nav-wrapper">
            <div class="nav-content">

                <!-- Bouton menu mobile -->
                <div class="mobile-menu-toggle">
                    <button type="button" id="mobile-menu-button" class="menu-btn"
                            aria-expanded="false" aria-controls="mobile-menu-deco"
                            aria-label="Ouvrir le menu de navigation">
                        <svg id="menu-open-icon" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" class="icon-menu" aria-hidden="true">
                            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <svg id="menu-close-icon" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" class="icon-menu hidden" aria-hidden="true">
                            <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

                <!-- Logo + liens de navigation -->
                <div class="nav-main">
                    <div class="nav-logo">
                        <!-- ✅ Balise <a> correctement fermée -->
                        <a href="/" aria-label="TroqueTout — Accueil">
                            <img class="logo" src="/images/logo.png" alt="TroqueTout">
                        </a>
                    </div>

                    <!-- ✅ Navigation desktop -->
                    <div class="nav-menu desktop-only">
                        <div class="nav-links" role="list">
                            <a href="/" class="nav-link" role="listitem">Accueil</a>
                            <a href="/demandes" class="nav-link" role="listitem">Les Demandes</a>
                            <a href="/contact" class="nav-link" role="listitem">Contact</a>
                        </div>
                    </div>
                </div>

                <!-- Actions à droite -->
                <div class="nav-actions">
                    <a href="/connexion" class="btn-connexion">Connexion</a>
                    <a href="/inscription" class="btn btn-success">S'inscrire</a>

                    <!-- ✅ Toggle thème (une seule instance dans le header) -->
                    <div class="theme-toggle-container">
                        <button type="button" class="theme-toggle"
                                onclick="toggleTheme()"
                                aria-label="Basculer entre mode clair et sombre">
                            <span class="theme-toggle-label">Thème</span>
                            <div class="toggle-switch" aria-hidden="true">
                                <div class="toggle-slider">
                                    <span class="icon-sun">☀️</span>
                                    <span class="icon-moon">🌙</span>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Menu mobile -->
        <div id="mobile-menu-deco" class="mobile-nav hidden" role="navigation" aria-label="Menu mobile">
            <div class="mobile-nav-content">
                <a href="/" class="mobile-nav-link">Accueil</a>
                <a href="/demandes" class="mobile-nav-link">Les Demandes</a>
                <a href="/contact" class="mobile-nav-link">Contact</a>
                <div class="mobile-nav-divider"></div>
                <a href="/connexion" class="mobile-nav-link">Connexion</a>
                <a href="/inscription" class="mobile-nav-link">S'inscrire</a>
            </div>
        </div>

    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('mobile-menu-button');
    if (!btn) return;

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        const menu     = document.getElementById('mobile-menu-deco');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');
        const isOpen   = !menu.classList.contains('hidden');

        menu.classList.toggle('hidden');
        openIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
        // ✅ Accessibilité : mettre à jour aria-expanded
        btn.setAttribute('aria-expanded', String(!isOpen));
    });

    // Fermer le menu en cliquant ailleurs
    document.addEventListener('click', function (e) {
        const menu = document.getElementById('mobile-menu-deco');
        if (menu && !btn.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
            document.getElementById('menu-open-icon')?.classList.remove('hidden');
            document.getElementById('menu-close-icon')?.classList.add('hidden');
            btn.setAttribute('aria-expanded', 'false');
        }
    });
});
</script>