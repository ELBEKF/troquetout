<?php
$search = $search ?? '';
$type = $type ?? '';
$etat = $etat ?? '';
$localisation = $localisation ?? '';
$sort = $sort ?? 'desc';
?>
<!-- MESSAGE DE BIENVENUE SELON LE STATUT -->
<section class="section section-welcome">
  
  <div class="container">
    <h2 class="center-large-text">
      <?php if (isset($_SESSION['user_id'])): ?>
        <span class="text-primary">Bonjour,</span>
        <span class="text-accent">
          <?= htmlspecialchars($_SESSION['user_nom']) ?>
        </span> !
        <?php else: ?>
          <h1 class="troquetout-title text-center mb-4"> 
            BIENVENUE SUR <span class="text-primary">TROQUETOUT</span> 
          </h1>
          <p class="explique">
            Bienvenue sur <strong>TrocTout</strong>, la plateforme qui facilite les échanges entre particuliers. 
            Ici, vous pouvez proposer vos objets dont vous n’avez plus besoin, découvrir de nouvelles annonces, 
            mettre en favori celles qui vous intéressent et entrer en contact directement avec les membres de la communauté. 
            Notre objectif est simple : donner une seconde vie aux objets tout en favorisant la convivialité et l’économie locale.
          </p>
          
          
          
          <div id="welcomeCarousel" class="carousel slide text-center" data-bs-ride="carousel"data-bs-ride="carousel"
          data-bs-interval="2000">
          <div class="carousel-inner">
            
            
            <div class="mt-4">
              <a href="/connexion" class="btn btn-primary">Se connecter</a>
              <a href="/inscription" class="btn btn-success ms-2">S'inscrire</a>
            </div>
            
            <?php endif; ?>
          </h2>
          
          
          
        </div>
</section>

<!-- FORMULAIRE DE RECHERCHE -->
<section class="section">
  <div class="container">
    <form method="GET" class="recherche">
      <div class="">
        <label for="search">Titre</label>
        <input type="text" name="search" id="search" placeholder="Rechercher par nom" value="<?= htmlspecialchars($search) ?>" class="form-control">
      </div>
      
      <div class="filtre">
        <label for="type">Type d'offre</label>
        <select name="type" id="type" class="form-select">
          <option value="">-- Tous les types --</option>
          <option value="don" <?= ($type === 'don') ? 'selected' : '' ?>>Don</option>
          <option value="location" <?= ($type === 'location') ? 'selected' : '' ?>>Location</option>
          <option value="pret" <?= ($type === 'pret') ? 'selected' : '' ?>>Prêt</option>
        </select>
      </div>

      <div class="filtre">
        <label for="etat">État</label>
        <select name="etat" id="etat" class="form-select">
          <option value="">-- Tous les états --</option>
          <option value="neuf" <?= ($etat === 'neuf') ? 'selected' : '' ?>>Neuf</option>
          <option value="bon" <?= ($etat === 'bon') ? 'selected' : '' ?>>Bon</option>
          <option value="usé" <?= ($etat === 'usé') ? 'selected' : '' ?>>Usé</option>
        </select>
      </div>

      <div class="filtre flex-fill">
        <label for="localisation">Localisation</label>
        <input type="text" name="localisation" id="localisation" placeholder="Ville" value="<?= htmlspecialchars($localisation) ?>" class="form-control">
      </div>filtre

      <div class="filtre">
        <label for="sort">Trier par date</label>
        <select name="sort" id="sort" class="form-select">
          <option value="desc" <?= ($sort === 'desc') ? 'selected' : '' ?>>Plus récentes</option>
          <option value="asc" <?= ($sort === 'asc') ? 'selected' : '' ?>>Plus anciennes</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">
         Rechercher
      </button>
    </form>

    <!-- Bouton Ajouter une offre -->
    <div class="offres-wrapper p-4 my-4">
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="offers/addOffer" class="btn btn-primary mb-4">
        Ajouter une offre
      </a>
    <?php else: ?>
      <button class="btn btn-outline-secondary w-100 mb-4" disabled>
        🔒 Connectez-vous pour ajouter une offre
      </button>
    <?php endif; ?>

    <!-- GRID DES OFFRES -->
    <div class="row">
      <?php foreach ($offers as $offer): ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card h-100 shadow-sm">
            <a href="/offers/detail/<?= urlencode($offer['id']) ?>">
              <img class="card-img-top" src="<?= htmlspecialchars($offer['photo']) ?>" alt="Image de l'offre" style="height: 200px; object-fit: contain;">
            </a>

            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($offer['titre']) ?></h5>
              <p class="card-text"><strong>Type :</strong> <?= htmlspecialchars($offer['type']) ?></p>
              <p class="card-text"><strong>Prix :</strong> <?= number_format($offer['prix'], 2) ?> €</p>
              <p class="card-text"><strong>Ville :</strong> <?= htmlspecialchars($offer['localisation']) ?></p>
              <p class="card-text"><strong>Disponibilité :</strong> <?= htmlspecialchars($offer['disponibilite']) ?></p>
              <p class="card-text"><strong>Statut :</strong> <?= $offer['statut'] ? '✅ Actif' : '⛔ Inactif' ?></p>

              <a href="/offers/detail/<?= urlencode($offer['id']) ?>" class="btn btn-outline-primary btn-sm mt-2">Voir détail</a>

              <?php if (
                isset($_SESSION['user_id']) &&
                ($_SESSION['user_id'] == $offer['user_id'] || ($_SESSION['user_role'] ?? '') === 'admin')
              ): ?>
                <a href="/deleteOffer/<?= urlencode($offer['id']) ?>" 
                  class="btn btn-outline-danger btn-sm mt-2"
                  onclick="return confirm('Êtes-vous sûr ?');">
                  Supprimer
                </a>
                
                <a href="/offers/modifoffer/<?= urlencode($offer['id']) ?>" class="btn btn-warning btn-sm mt-2">Modifier</a>
              <?php endif; ?>
            </div>

           <div class="p-2">
  <?php if (isset($_SESSION['user_id'])): ?>
    <form action="/offers/addfavoris/" method="POST" class="favoris-form">
      <input type="hidden" name="offer_id" value="<?= $offer['id'] ?>">
      <?php 
        // Déterminer l'état initial du bouton basé sur is_favori
        $isFavori = $offer['is_favori'] ?? false;
        $btnClass = $isFavori ? 'btn btn-danger' : 'btn btn-outline-danger';
        $btnIcon = $isFavori ? '<i class="bi bi-heart-fill"></i>' : '<i class="bi bi-heart"></i>';
      ?>
      <button 
        type="submit" 
        class="<?= $btnClass ?> w-100 favoris-btn"
        onclick="toggleFavori(this, event)">
        <?= $btnIcon ?>
      </button>
    </form>
  <?php else: ?>
    <button 
      class="btn btn-outline-secondary w-100 favoris-btn"
      onclick="alert('Connectez-vous pour ajouter aux favoris !')">
      <i class="bi bi-heart"></i>
    </button>
  <?php endif; ?>

            </div>
          </div>
        </div>
      <?php endforeach; ?>
      </div>
    </div>
    
  </div>
</section>
<script>
function toggleFavori(button, event) {
  event.preventDefault(); // Empêche le submit classique

  const form = button.closest("form");

  fetch(form.action, {
    method: form.method,
    body: new FormData(form)
  })
  .then(response => response.text())
  .then(() => {
    // Vérifie l'état actuel
    const isCurrentlyFavori = button.classList.contains("btn-danger");

    if (isCurrentlyFavori) {
      // Si déjà en favoris → on retire
      button.classList.remove("btn-danger");
      button.classList.add("btn-outline-danger");
      button.innerHTML = '<i class="bi bi-heart"></i>'; // cœur vide
    } else {
      // Si pas encore en favoris → on ajoute
      button.classList.remove("btn-outline-danger");
      button.classList.add("btn-danger");
      button.innerHTML = '<i class="bi bi-heart-fill"></i>'; // cœur plein
    }
  })
  .catch(error => {
    console.error("Erreur:", error);
    alert("Une erreur s'est produite lors de la modification des favoris.");
  });
}
</script>


