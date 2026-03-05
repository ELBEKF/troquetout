<header class="header modern-nav" role="banner">
  <nav class="nav-container" aria-label="Navigation principale">
    <div class="nav-wrapper">
      <div class="nav-content">

        <!-- Bouton menu mobile -->
        <div class="mobile-menu-toggle">
          <button type="button" id="mobile-menu-button" class="menu-btn"
                  aria-expanded="false" aria-controls="mobile-menu"
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

        <!-- Logo + liens desktop -->
        <div class="nav-main">
          <div class="nav-logo">
            <a href="/" aria-label="TroqueTout — Accueil">
              <img class="logo" src="/images/logo.png" alt="TroqueTout">
            </a>
          </div>

          <?php if (isset($_SESSION['user_id'])): ?>
          <div class="nav-menu desktop-only">
            <div class="nav-links" role="list">
              <a href="/"         class="nav-link" role="listitem">Accueil</a>
              <a href="/demandes" class="nav-link" role="listitem">Les Demandes</a>
              <a href="/contact"  class="nav-link" role="listitem">Contact</a>
              <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
              <a href="/admin"    class="nav-link" role="listitem">Dashboard</a>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>
        </div>

        <!-- ✅ Actions à droite — toggle thème intégré ici -->
        <div class="nav-actions">

          <?php if (isset($_SESSION['user_id'])): ?>

            <!-- Toggle thème -->
            <button type="button" class="theme-toggle"
                    onclick="toggleTheme()"
                    aria-label="Basculer entre mode clair et sombre">
              <span class="theme-toggle-label desktop-only">Thème</span>
              <div class="toggle-switch" aria-hidden="true">
                <div class="toggle-slider">
                  <span class="icon-sun">☀️</span>
                  <span class="icon-moon">🌙</span>
                </div>
              </div>
            </button>

            <!-- Bouton Messages -->
            <a href="/messages_recus" class="icon-btn" aria-label="Mes messages">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" class="icon" aria-hidden="true">
                <path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"
                      stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>

            <!-- Menu utilisateur -->
            <div class="user-menu-wrapper">
              <button type="button" id="user-menu-button" class="user-avatar"
                      aria-expanded="false" aria-controls="user-menu"
                      aria-label="Ouvrir le menu utilisateur">
                <div class="avatar-circle" aria-hidden="true">
                  <?php
                    echo isset($_SESSION['user_nom'])
                      ? strtoupper(substr($_SESSION['user_nom'], 0, 1))
                      : 'U';
                  ?>
                </div>
              </button>

              <!-- Dropdown -->
              <div id="user-menu" class="dropdown-menu hidden" role="menu">
                <div class="dropdown-user-header">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                       stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                       style="width:1.125rem;height:1.125rem;flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                  </svg>
                  <?= htmlspecialchars($_SESSION['user_nom']) ?>
                </div>
                <div class="dropdown-divider"></div>
                <a href="/profil"      class="dropdown-item" role="menuitem">Mon Profil</a>
                <a href="/mesoffres"   class="dropdown-item" role="menuitem">Mes annonces</a>
                <a href="/mesdemandes" class="dropdown-item" role="menuitem">Mes demandes</a>
                <a href="/mesfavoris"  class="dropdown-item" role="menuitem">Mes Favoris</a>
                <div class="dropdown-divider"></div>
                <form action="/deconnexion" method="post">
                  <button type="submit" class="dropdown-item logout-btn" role="menuitem">
                    Déconnexion
                  </button>
                </form>
              </div>
            </div>

          <?php else: ?>
            <!-- Visiteur non connecté -->
            <button type="button" class="theme-toggle"
                    onclick="toggleTheme()"
                    aria-label="Basculer entre mode clair et sombre">
              <span class="theme-toggle-label desktop-only">Thème</span>
              <div class="toggle-switch" aria-hidden="true">
                <div class="toggle-slider">
                  <span class="icon-sun">☀️</span>
                  <span class="icon-moon">🌙</span>
                </div>
              </div>
            </button>
            <a href="/connexion" class="btn btn-primary">Connexion</a>
          <?php endif; ?>

        </div>
      </div>
    </div>

    <!-- Menu mobile -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <div id="mobile-menu" class="mobile-nav hidden" role="navigation" aria-label="Menu mobile">
      <div class="mobile-nav-content">
        <a href="/"         class="mobile-nav-link">Accueil</a>
        <a href="/demandes" class="mobile-nav-link">Les Demandes</a>
        <a href="/contact"  class="mobile-nav-link">Contact</a>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <a href="/admin"    class="mobile-nav-link">Dashboard</a>
        <?php endif; ?>
        <div class="mobile-nav-divider"></div>
        <a href="/profil"      class="mobile-nav-link">Mon Profil</a>
        <a href="/mesoffres"   class="mobile-nav-link">Mes annonces</a>
        <a href="/mesdemandes" class="mobile-nav-link">Mes demandes</a>
        <a href="/mesfavoris"  class="mobile-nav-link">Mes Favoris</a>
      </div>
    </div>
    <?php endif; ?>

  </nav>
</header>