<?php
/**
 * Partiel : En-tête (Header) — Utilisateur connecté
 * Optimisé RNCP : Sémantique, Accessibilité, zéro style inline, zéro script inline
 */
?>
<header class="header modern-nav sticky-top" role="banner">
    <nav class="nav-container container-fluid" aria-label="Navigation principale">
        <div class="nav-wrapper d-flex align-items-center justify-content-between py-2">

            <div class="d-flex align-items-center">

                <!-- Hamburger — visible uniquement sur mobile (d-lg-none) -->
                <button type="button"
                        id="mobile-menu-button"
                        class="btn btn-link d-lg-none me-2"
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        aria-label="Ouvrir le menu de navigation">
                    <i class="bi bi-list fs-2 text-dark" id="menu-open-icon" aria-hidden="true"></i>
                    <i class="bi bi-x-lg fs-2 text-dark hidden" id="menu-close-icon" aria-hidden="true"></i>
                </button>

                <div class="nav-logo me-4">
                    <a href="/" aria-label="TroqueTout — Retour à l'accueil">
                        <img class="logo" src="/images/logo.png" alt="TroqueTout">
                    </a>
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                <div class="nav-links d-none d-lg-flex gap-3" role="menubar">
                    <a href="/"          class="nav-link fw-semibold" role="menuitem">Accueil</a>
                    <a href="/demandes"  class="nav-link fw-semibold" role="menuitem">Les Demandes</a>
                    <a href="/contact"   class="nav-link fw-semibold" role="menuitem">Contact</a>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <a href="/admin" class="nav-link fw-semibold text-primary" role="menuitem">Dashboard</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="nav-actions d-flex align-items-center gap-3">

                <!-- Toggle thème — label masqué sur mobile via CSS (section 33) -->
                <button type="button"
                        class="theme-toggle btn btn-sm rounded-pill d-flex align-items-center gap-2 px-3"
                        onclick="toggleTheme()"
                        aria-label="Changer le mode de couleur">
                    <i class="bi bi-sun-fill icon-sun" aria-hidden="true"></i>
                    <span class="nav-actions .theme-toggle-label small fw-bold">Thème</span>
                    <i class="bi bi-moon-stars-fill icon-moon" aria-hidden="true"></i>
                </button>

                <?php if (isset($_SESSION['user_id'])): ?>

                    <a href="/messages_recus"
                       class="btn btn-outline-dark rounded-circle p-2 position-relative"
                       aria-label="Voir mes messages<?= (!empty($_SESSION['unread_count']) && $_SESSION['unread_count'] > 0) ? ' (' . $_SESSION['unread_count'] . ' non lu' . ($_SESSION['unread_count'] > 1 ? 's' : '') . ')' : '' ?>">
                        <i class="bi bi-envelope fs-5" aria-hidden="true"></i>
                        <?php if (!empty($_SESSION['unread_count']) && $_SESSION['unread_count'] > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light badge-notif"
                                  aria-label="<?= $_SESSION['unread_count'] ?> message<?= $_SESSION['unread_count'] > 1 ? 's' : '' ?> non lu<?= $_SESSION['unread_count'] > 1 ? 's' : '' ?>">
                                <?= $_SESSION['unread_count'] ?>
                            </span>
                        <?php endif; ?>
                    </a>

                    <!-- Dropdown utilisateur — géré par Bootstrap data-bs-toggle -->
                    <div class="dropdown">
                        <button class="btn btn-link p-0 border-0"
                                type="button"
                                id="userDropdown"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                aria-label="Menu utilisateur <?= htmlspecialchars($_SESSION['user_nom'] ?? '') ?>">
                            <div class="avatar-circle avatar-circle--sm shadow-sm">
                                <?= strtoupper(substr($_SESSION['user_nom'] ?? 'U', 0, 1)) ?>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 card-wrap--r-lg"
                            aria-labelledby="userDropdown">
                            <li class="px-3 py-2 small border-bottom">
                                <span class="text-muted d-block small">Connecté en tant que</span>
                                <span class="fw-bold"><?= htmlspecialchars($_SESSION['user_nom'] ?? '') ?></span>
                            </li>
                            <li><a class="dropdown-item py-2" href="/profil">
                                <i class="bi bi-person me-2" aria-hidden="true"></i>Mon Profil</a></li>
                            <li><a class="dropdown-item py-2" href="/mesoffres">
                                <i class="bi bi-card-list me-2" aria-hidden="true"></i>Mes annonces</a></li>
                            <li><a class="dropdown-item py-2" href="/mesdemandes">
                                <i class="bi bi-chat-left-quote me-2" aria-hidden="true"></i>Mes demandes</a></li>
                            <li><a class="dropdown-item py-2" href="/mesfavoris">
                                <i class="bi bi-heart me-2" aria-hidden="true"></i>Mes Favoris</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="/deconnexion" method="post" class="m-0">
                                    <button type="submit" class="dropdown-item text-danger py-2">
                                        <i class="bi bi-box-arrow-right me-2" aria-hidden="true"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                <?php else: ?>
                    <a href="/connexion" class="btn btn-primary px-4 fw-bold rounded-pill">Connexion</a>
                <?php endif; ?>

            </div>
        </div>

        <!-- Menu mobile — classe "hidden" (CSS custom) pour correspondre à scripts.js -->
        <?php if (isset($_SESSION['user_id'])): ?>
        <div id="mobile-menu"
             class="d-lg-none hidden bg-white border-top shadow-sm w-100 position-absolute start-0 py-3 px-4"
             role="navigation"
             aria-label="Menu mobile">
            <div class="d-flex flex-column gap-3">
                <a href="/"         class="text-dark text-decoration-none fw-bold">
                    <i class="bi bi-house me-2" aria-hidden="true"></i>Accueil</a>
                <a href="/demandes" class="text-dark text-decoration-none fw-bold">
                    <i class="bi bi-search me-2" aria-hidden="true"></i>Les Demandes</a>
                <a href="/contact"  class="text-dark text-decoration-none fw-bold">
                    <i class="bi bi-envelope me-2" aria-hidden="true"></i>Contact</a>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="/admin"    class="text-primary text-decoration-none fw-bold">
                    <i class="bi bi-speedometer2 me-2" aria-hidden="true"></i>Dashboard</a>
                <?php endif; ?>
                <hr class="my-1">
                <a href="/profil"    class="text-dark text-decoration-none small">
                    <i class="bi bi-person me-2" aria-hidden="true"></i>Mon Profil</a>
                <a href="/mesoffres" class="text-dark text-decoration-none small">
                    <i class="bi bi-card-list me-2" aria-hidden="true"></i>Mes annonces</a>
                <a href="/mesfavoris" class="text-dark text-decoration-none small">
                    <i class="bi bi-heart me-2" aria-hidden="true"></i>Mes Favoris</a>
            </div>
        </div>
        <?php endif; ?>

    </nav>
</header>