<link rel="stylesheet" href="./css/header.css">

<header class="header modern-nav">
  <nav class="nav-container">
    <div class="nav-wrapper">
      <div class="nav-content">
        <!-- Mobile menu button -->
        <div class="mobile-menu-toggle">
          <button type="button" id="mobile-menu-button" class="menu-btn">
            <span class="sr-only">Ouvrir le menu</span>
            <svg id="menu-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="icon-menu">
              <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <svg id="menu-close-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="icon-menu hidden">
              <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>

        <!-- Logo et menu principal -->
        <div class="nav-main">
          <div class="nav-logo">
            <?php if (isset($_SESSION['user_id'])): ?>
              <a href="/">
            <?php endif; ?>
            <img class="logo" src="/images/logo.png" alt="TroqueTout" />
            <?php if (isset($_SESSION['user_id'])): ?>
              </a>
            <?php endif; ?>
          </div>

          <?php if (isset($_SESSION['user_id'])): ?>
          <div class="nav-menu desktop-only">
            <div class="nav-links">
              <a href="/" class="nav-link">Accueil</a>
              <a href="/demandes" class="nav-link">Les Demandes</a>
              <a href="/contact" class="nav-link">Contact</a>
              <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
              <a href="/admin" class="nav-link">Dashboard</a>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>
        </div>

        <!-- Actions à droite -->
        <div class="nav-actions">
          <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Bouton Messages -->
            <a href="/messages_recus" class="icon-btn" title="Messages">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="icon">
                <path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </a>

            <!-- Menu utilisateur -->
            <div class="user-menu-wrapper">
              <button type="button" id="user-menu-button" class="user-avatar">
                <span class="sr-only">Ouvrir le menu utilisateur</span>

                <div class="avatar-circle">
                  <?php 
                  if (isset($_SESSION['user_nom'])) {
                    echo strtoupper(substr($_SESSION['user_nom'], 0, 1));
                  } else {
                    echo 'U';
                  }
                  ?>
                </div>
              </button>
              
              <!-- Dropdown menu -->
              <div id="user-menu" class="dropdown-menu hidden">
                <div class="mobile-user-info" style="padding:10px; font-weight:bold; text-align:center; display:flex; align-items:center; justify-content:center; gap:6px;">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px; height:20px;">
    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
  </svg>

  <?= htmlspecialchars($_SESSION['user_nom']) ?>
  
</div>

            <div class="mobile-nav-divider"></div>
                <a href="/profil" class="dropdown-item">Mon Profil</a>
                <a href="/mesoffres" class="dropdown-item">Mes annonces</a>
                <a href="/mesdemandes" class="dropdown-item">Mes demandes</a>
                <a href="/mesfavoris" class="dropdown-item">Mes Favoris</a>
                <div class="dropdown-divider"></div>
                <form action="/deconnexion" method="post">
                  <button type="submit" class="dropdown-item logout-btn">Déconnexion</button>
                </form>
              </div>
            </div>
          <?php else: ?>
            <a href="/connexion" class="btn btn-primary">Connexion</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Menu mobile -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <div id="mobile-menu" class="mobile-nav hidden">
      <div class="mobile-nav-content">
        <a href="/" class="mobile-nav-link">Accueil</a>
        <a href="/demandes" class="mobile-nav-link">Les Demandes</a>
        <a href="/contact" class="mobile-nav-link">Contact</a>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <a href="/admin" class="mobile-nav-link">Dashboard</a>
        <?php endif; ?>
        <div class="mobile-nav-divider"></div>


        <a href="/profil" class="mobile-nav-link">Mon Profil</a>
        <a href="/mesoffres" class="mobile-nav-link">Mes annonces</a>
        <a href="/mesdemandes" class="mobile-nav-link">Mes demandes</a>
        <a href="/mesfavoris" class="mobile-nav-link">Mes Favoris</a>
      </div>
    </div>
    <?php endif; ?>
  </nav>
  <!-- À placer après l'ouverture de <body> -->
<div class="theme-toggle-container">
    <div class="theme-toggle" onclick="toggleTheme()">
        <span class="theme-toggle-label">Thème</span>
        <div class="toggle-switch">
            <div class="toggle-slider">
                <span class="icon-sun">☀️</span>
                <span class="icon-moon">🌙</span>
            </div>
        </div>
    </div>
</div>
</header>

<script>
// Attendre que le DOM soit complètement chargé
document.addEventListener('DOMContentLoaded', function() {
  
  // Toggle menu mobile
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  if (mobileMenuButton) {
    mobileMenuButton.addEventListener('click', function(e) {
      e.stopPropagation();
      const menu = document.getElementById('mobile-menu');
      const openIcon = document.getElementById('menu-open-icon');
      const closeIcon = document.getElementById('menu-close-icon');
      
      if (menu) menu.classList.toggle('hidden');
      if (openIcon) openIcon.classList.toggle('hidden');
      if (closeIcon) closeIcon.classList.toggle('hidden');
    });
  }

  // Toggle menu utilisateur
  const userMenuButton = document.getElementById('user-menu-button');
  if (userMenuButton) {
    userMenuButton.addEventListener('click', function(e) {
      e.stopPropagation();
      const menu = document.getElementById('user-menu');
      if (menu) menu.classList.toggle('hidden');
    });
  }

  // Fermer le menu utilisateur si on clique ailleurs
  document.addEventListener('click', function(event) {
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    
    if (userMenuButton && userMenu && 
        !userMenuButton.contains(event.target) && 
        !userMenu.contains(event.target)) {
      userMenu.classList.add('hidden');
    }
  });

  // Fermer le menu mobile en cliquant sur un lien
  const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
  mobileNavLinks.forEach(function(link) {
    link.addEventListener('click', function() {
      const menu = document.getElementById('mobile-menu');
      const openIcon = document.getElementById('menu-open-icon');
      const closeIcon = document.getElementById('menu-close-icon');
      
      if (menu) menu.classList.add('hidden');
      if (openIcon) openIcon.classList.remove('hidden');
      if (closeIcon) closeIcon.classList.add('hidden');
    });
  });
  
});
</script>