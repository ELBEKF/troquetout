<?php if (empty($offers)): ?>
    <div class="text-center py-5 card glass-effect">
        <i class="bi bi-emoji-frown display-1 text-muted mb-3"></i>
        <p class="fs-4 text-muted">Aucune offre ne correspond à votre recherche.</p>
        <a href="/" class="btn btn-outline-primary">Réinitialiser les filtres</a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($offers as $offer): ?>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <article class="card h-100 glass-effect border-0 shadow-hover overflow-hidden">
                    <div class="position-relative">
                        <img src="<?= htmlspecialchars($offer['photo']) ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($offer['titre']) ?> — <?= htmlspecialchars($offer['localisation']) ?>"
                             style="height: 200px; object-fit: cover;"
                             loading="lazy">
                        <span class="badge bg-primary position-absolute top-0 end-0 m-3 shadow-sm">
                            <?= ucfirst(htmlspecialchars($offer['type'])) ?>
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h5 card-title fw-bold mb-2"><?= htmlspecialchars($offer['titre']) ?></h3>
                        <p class="small text-muted mb-3">
                            <i class="bi bi-geo-alt me-1"></i>
                            <?= htmlspecialchars($offer['localisation']) ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <a href="/offers/detail/<?= urlencode($offer['id']) ?>"
                               class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold"
                               aria-label="Voir les détails de : <?= htmlspecialchars($offer['titre']) ?>">
                                Voir les détails
                            </a>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php $isFavori = (isset($offer['is_favori']) && $offer['is_favori'] == 1); ?>
                                <form action="/offers/addfavoris" method="POST" class="m-0">
                                    <input type="hidden" name="offer_id" value="<?= $offer['id'] ?>">
                                    <button type="submit"
                                            class="btn <?= $isFavori ? 'btn-danger' : 'btn-outline-danger' ?> btn-sm rounded-circle p-2 shadow-sm"
                                            aria-label="<?= $isFavori ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>">
                                        <i class="bi <?= $isFavori ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>