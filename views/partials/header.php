
<header class="header">
  <div class="container">
      <div class="row">
          <div class="col-md-12">
              <nav class="navbar navbar-expand-lg navbar-light navigation">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a class="navbar-brand" href="/">
                      <?php endif; ?>
                      <img class="logo" src="/images/logo.png" alt="TroqueTout" style="width: 120px; height: auto;">
                  </a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
                          aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarContent">
                      <ul class="navbar-nav ml-auto main-nav">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item"><a class="nav-link" href="/">Accueil</a></li>

                          <li class="nav-item"><a class="nav-link" href="/demandes">Les Demandes</a></li>

                          
                              <li class="nav-item"><a class="nav-link" href="/mesoffres">Mes annonces</a></li>
                              <li class="nav-item"><a class="nav-link" href="/mesdemandes">Mes demandes</a></li>
                              <li class="nav-item"><a class="nav-link" href="/mesfavoris">Mes Favoris</a></li>
                          

                          <!-- Forcer la ligne suivante -->
                          <li class="break"></li>

                          
                              <li class="nav-item"><a class="nav-link" href="/messages_recus">Messages</a></li>
                              <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                              
                              <?php endif; ?>

                          <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                              <li class="nav-item"><a class="nav-link" href="/admin">DASHBOARD</a></li>
                          <?php endif; ?>

                          <?php if (isset($_SESSION['user_id'])): ?>
                              <li class="nav-item"><a class="nav-link" href="/profil">Mon Profil</a></li>
                          <?php endif; ?>
                      </ul>
                  </div>

                  <div class="nav-item">
                      <?php if (isset($_SESSION['user_id'])): ?>
                          <form action="/deconnexion" method="post">
                              <button type="submit" class="btn btn-danger btn-sm">Déconnexion</button>
                          </form>
                      <?php else: ?>
                          <a href="/connexion" class="btn btn-primary btn-sm">Connexion</a>
                      <?php endif; ?>
                  </div>
              </nav>
          </div>
      </div>
  </div>
</header>
