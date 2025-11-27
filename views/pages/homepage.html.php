<link rel="stylesheet" href="/css/homepage.css">
<?php
$search = $search ?? '';
$type = $type ?? '';
$etat = $etat ?? '';
$localisation = $localisation ?? '';
$sort = $sort ?? 'desc';
?>

<!-- HERO SECTION -->
<div class="hero-section">
  <h1 class="hero-title">L'avenir du partage commence ici</h1>
  <p class="hero-subtitle">Découvrez une plateforme moderne de partage et d'échange. Donnez, louez ou prêtez simplement vos objets.</p>
</div>

<!-- FORMULAIRE DE RECHERCHE -->
<div class="container">
  <form method="GET" class="recherche">
    <div class="search">
      <label for="search">Titre</label>
      <input type="text" name="search" id="search" placeholder="Rechercher par nom" value="<?= htmlspecialchars($search) ?>" class="form-control">
    </div>
    
    <div class="filtre">
      <label for="type">Type d'offre</label>
      <select name="type" id="type" class="form-select">
        <option value="">Tous les types</option>
        <option value="don" <?= ($type === 'don') ? 'selected' : '' ?>>Don</option>
        <option value="location" <?= ($type === 'location') ? 'selected' : '' ?>>Location</option>
        <option value="pret" <?= ($type === 'pret') ? 'selected' : '' ?>>Prêt</option>
      </select>
    </div>

    <div class="filtre">
      <label for="etat">État</label>
      <select name="etat" id="etat" class="form-select">
        <option value="">Tous les états</option>
        <option value="neuf" <?= ($etat === 'neuf') ? 'selected' : '' ?>>Neuf</option>
        <option value="bon" <?= ($etat === 'bon') ? 'selected' : '' ?>>Bon</option>
        <option value="usé" <?= ($etat === 'usé') ? 'selected' : '' ?>>Usé</option>
      </select>
    </div>

    <div class="filtre">
      <label for="localisation">Localisation</label>
      <input type="text" name="localisation" id="localisation" placeholder="Ville" value="<?= htmlspecialchars($localisation) ?>" class="form-control">
    </div>

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

  <section class="section">
    <!-- Bouton Ajouter une offre -->
    <div class="offres-wrapper">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="offers/addOffer" class="btn btn-primary btn-add">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
          </svg>
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
            <div class="card">
              <a href="/offers/detail/<?= urlencode($offer['id']) ?>">
                <img class="card-img-top" src="<?= htmlspecialchars($offer['photo']) ?>" alt="Image de l'offre">
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
                      $isFavori = $offer['is_favori'] ?? false;
                      $btnClass = $isFavori ? 'btn btn-danger' : 'btn btn-outline-danger';
                      $btnIcon = $isFavori ? '<i class="bi bi-heart-fill"></i>' : '<i class="bi bi-heart"></i>';
                    ?>
                    <button 
                      type="submit" 
                      class="<?= $btnClass ?> favoris-btn"
                      onclick="toggleFavori(this, event)">
                      <?= $btnIcon ?>
                    </button>
                  </form>
                <?php else: ?>
                  <button 
                    class="btn btn-outline-secondary favoris-btn"
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
  </section>
</div>

<script>
function toggleFavori(button, event) {
  event.preventDefault();

  const form = button.closest("form");

  fetch(form.action, {
    method: form.method,
    body: new FormData(form)
  })
  .then(response => response.text())
  .then(() => {
    const isCurrentlyFavori = button.classList.contains("btn-danger");

    if (isCurrentlyFavori) {
      button.classList.remove("btn-danger");
      button.classList.add("btn-outline-danger");
      button.innerHTML = '<i class="bi bi-heart"></i>';
    } else {
      button.classList.remove("btn-outline-danger");
      button.classList.add("btn-danger");
      button.innerHTML = '<i class="bi bi-heart-fill"></i>';
    }
  })
  .catch(error => {
    console.error("Erreur:", error);
    alert("Une erreur s'est produite lors de la modification des favoris.");
  });
}
</script>