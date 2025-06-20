<div class="container my-5">
    <h1 class="mb-4">TOUTES LES OFFRES</h1>

    <a href="/addOffers.php" class="btn btn-primary mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
        </svg>
        Ajouter une offre
    </a>

    <div class="row">
        <?php foreach ($offers as $offer): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($offer['photo']) ?>" class="card-img-top" alt="Photoooooo" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
    <h5 class="card-title"><?= htmlspecialchars($offer['titre']) ?></h5>
    <p class="card-text mb-1"><strong>Type:</strong> <?= htmlspecialchars($offer['type']) ?></p>
    <p class="card-text mb-1"><strong>Catégorie:</strong> <?= htmlspecialchars($offer['categorie']) ?></p>
    <p class="card-text mb-1"><strong>État:</strong> <?= htmlspecialchars($offer['etat']) ?></p>
    <p class="card-text mb-1"><strong>Prix:</strong> <?= number_format($offer['prix'], 2) ?> €</p>
    <p class="card-text mb-1"><strong>Caution:</strong> <?= number_format($offer['caution'], 2) ?> €</p>
    <p class="card-text mb-1"><strong>Ville:</strong> <?= htmlspecialchars($offer['localisation']) ?></p>
    <p class="card-text mb-2"><strong>Disponibilité:</strong> <?= htmlspecialchars($offer['disponibilite']) ?></p>
    <p class="card-text">
        <strong>Statut:</strong> <?= $offer['statut'] ? '✅ Actif' : '⛔ Inactif' ?>
    </p>
    <a href="/offerdetail.php?id=<?= urlencode($offer['id']) ?>" class="btn btn-outline-primary mt-auto">Détail</a>
</div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
