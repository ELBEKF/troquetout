<div class="container my-5">
    <h1 class="mb-4">Mes Offres Favoris</h1>

    <?php if (empty($offers)): ?>
        <p>Vous n'avez pas encore ajouté d'offres en favoris.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($offers as $offer): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($offer['photo']) ?>" class="card-img-top" alt="Photo" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($offer['titre']) ?></h5>
                            <p class="card-text mb-1"><strong>Type:</strong> <?= htmlspecialchars($offer['type']) ?></p>
                            <p class="card-text mb-1"><strong>Prix:</strong> <?= number_format($offer['prix'], 2) ?> €</p>
                            <p class="card-text mb-1"><strong>Ville:</strong> <?= htmlspecialchars($offer['localisation']) ?></p>
                            <p class="card-text mb-2"><strong>Disponibilité:</strong> <?= htmlspecialchars($offer['disponibilite']) ?></p>
                            <p class="card-text">
                                <strong>Statut:</strong> <?= $offer['statut'] ? '✅ Actif' : '⛔ Inactif' ?>
                            </p>
                            <a href="/offerdetail.php?id=<?= urlencode($offer['id']) ?>" class="btn btn-outline-primary mt-2">Détail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
