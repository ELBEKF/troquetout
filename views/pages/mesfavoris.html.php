<div class="container my-5">
    <h1 class="form-title">Mes Offres Favoris</h1>

    <?php if (empty($offers)): ?>
        <div class="request-alert">
        <p>Vous n'avez pas encore ajouté d'offres en favoris.</p></div>
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
                        <a href="/offers/detail/<?= urlencode($offer['id']) ?>" class="btn btn-outline-primary mt-2">Détail</a>
                        </div>
<form action="/mesfavoris/togglefavoris/" method="POST" class="mt-2">
                            <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['id']) ?>">
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-heart-fill"></i> Retirer des favoris
                            </button>
                        </form>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
