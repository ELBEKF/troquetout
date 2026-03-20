
<header class="header modern-nav sticky-top" role="banner">
    <nav class="nav-container container-fluid" aria-label="Navigation principale">
        <div class="nav-wrapper d-flex align-items-center justify-content-between py-2">

            <div class="d-flex align-items-center">

                <!-- Hamburger -->
                <button type="button"
                        id="mobile-menu-button"
                        class="btn btn-link d-lg-none me-2"
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        aria-label="Ouvrir le menu de navigation">
                    <i class="bi bi-list fs-2 text-dark" id="menu-open-icon" aria-hidden="true"></i>
                    <i class="bi bi-x-lg fs-2 text-dark hidden"  id="menu-close-icon" aria-hidden="true"></i>
                </button>

                <div class="nav-logo me-4">
                    <a href="/" aria-label="TroqueTout — Retour à l'accueil">
                        <img class="logo" src="/images/logo.png" alt="TroqueTout">
                    </a>
                </div>

                <div class="nav-links d-none d-lg-flex gap-4" role="menubar">
                    <a href="/"         class="nav-link fw-semibold" role="menuitem">Accueil</a>
                    <a href="/demandes" class="nav-link fw-semibold" role="menuitem">Les Demandes</a>
                    <a href="/contact"  class="nav-link fw-semibold" role="menuitem">Contact</a>
                </div>
            </div>

            <div class="nav-actions d-flex align-items-center gap-2 gap-md-3">

                <button type="button"
                        class="theme-toggle btn btn-sm rounded-pill d-flex align-items-center gap-2 px-3"
                        onclick="toggleTheme()"
                        aria-label="Changer le mode de couleur">
                    <i class="bi bi-sun-fill icon-sun" aria-hidden="true"></i>
                    <span class="theme-toggle-label small fw-bold">Thème</span>
                    <i class="bi bi-moon-stars-fill icon-moon" aria-hidden="true"></i>
                </button>

                <div class="auth-buttons d-flex gap-2">
                    <a href="/connexion"  class="btn btn-outline-primary rounded-pill px-3 px-md-4 fw-bold">Connexion</a>
                    <a href="/inscription" class="btn btn-primary rounded-pill px-3 px-md-4 fw-bold shadow-sm">S'inscrire</a>
                </div>
            </div>
        </div>

        
        <div id="mobile-menu"
             class="d-lg-none hidden bg-white border-top shadow-sm w-100 position-absolute start-0 py-4 px-4"
             role="navigation"
             aria-label="Menu mobile visiteur">
            <div class="d-flex flex-column gap-3">
                <a href="/"         class="text-dark text-decoration-none fw-bold fs-5">
                    <i class="bi bi-house me-2" aria-hidden="true"></i>Accueil</a>
                <a href="/demandes" class="text-dark text-decoration-none fw-bold fs-5">
                    <i class="bi bi-search me-2" aria-hidden="true"></i>Les Demandes</a>
                <a href="/contact"  class="text-dark text-decoration-none fw-bold fs-5">
                    <i class="bi bi-envelope me-2" aria-hidden="true"></i>Contact</a>

                <div class="border-top my-2"></div>

                <div class="d-grid gap-2">
                    <a href="/connexion"   class="btn btn-outline-primary fw-bold py-2">Connexion</a>
                    <a href="/inscription" class="btn btn-primary fw-bold py-2">S'inscrire</a>
                </div>

                <button type="button"
                        class="btn btn-light mt-2 w-100"
                        onclick="toggleTheme()"
                        aria-label="Changer le thème">
                    <i class="bi bi-circle-half me-2" aria-hidden="true"></i>Changer le thème
                </button>
            </div>
        </div>

    </nav>
</header>