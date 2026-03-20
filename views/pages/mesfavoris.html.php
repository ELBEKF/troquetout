<main class="container py-5">
    <header class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">Mes Coups de Cœur</h1>
        <p class="text-muted fs-5">Retrouvez ici toutes les offres que vous avez mises de côté.</p>
    </header>

    <?php if (empty($offers)): ?>
        <div class="card glass-effect border-0 text-center p-5 shadow-sm mx-auto card-wrap card-wrap--sm">
            <div class="mb-4">
                <i class="bi bi-heart text-muted icon-xl-muted" aria-hidden="true"></i>
            </div>
            <h2 class="h4 fw-bold">Votre liste est vide</h2>
            <p class="text-muted mb-4">Parcourez les annonces et cliquez sur le petit cœur pour les enregistrer ici.</p>
            <a href="/" class="btn btn-primary px-4 py-2 fw-bold">Découvrir les offres</a>
        </div>
    <?php else: ?>

    <ul class="row list-unstyled g-4" role="list">
        <?php foreach ($offers as $offer): ?>
            <li class="col-sm-12 col-md-6 col-lg-4">
                <article class="card h-100 glass-effect border-0 shadow-hover overflow-hidden card-wrap--r-lg">
                    
                    <div class="position-relative">
                        <img src="<?= htmlspecialchars($offer['photo']) ?>" 
                             class="card-img-top img-favoris" 
                             alt="Photo de : <?= htmlspecialchars($offer['titre']) ?>">
                        <span class="badge bg-primary position-absolute top-0 end-0 m-3 shadow-sm">
                            <?= ucfirst(htmlspecialchars($offer['type'])) ?>
                        </span>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <h2 class="h5 fw-bold mb-2"><?= htmlspecialchars($offer['titre']) ?></h2>
                        
                        <div class="mb-3 small">
                            <p class="mb-1 text-muted">
                                <i class="bi bi-geo-alt me-2 text-primary" aria-hidden="true"></i><?= htmlspecialchars($offer['localisation']) ?>
                            </p>
                            <p class="mb-1 text-muted">
                                <i class="bi bi-tag me-2 text-primary" aria-hidden="true"></i><?= number_format($offer['prix'], 2) ?> €
                            </p>
                            <p class="mb-0 text-muted">
                                <i class="bi bi-calendar-check me-2 text-primary" aria-hidden="true"></i>Dispo : <?= htmlspecialchars($offer['disponibilite']) ?>
                            </p>
                        </div>

                        <div class="mt-auto pt-3 border-top">
                            <div class="d-flex gap-2">
                                <a href="/offers/detail/<?= (int)$offer['id'] ?>" 
                                   class="btn btn-outline-primary btn-sm flex-grow-1 fw-bold">
                                    Voir détail
                                </a>
                                
                                <form action="/mesfavoris/togglefavoris/" method="POST" class="flex-grow-1">
                                    <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['id']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold" 
                                            aria-label="Retirer des favoris">
                                        <i class="bi bi-heart-fill me-1" aria-hidden="true"></i> Retirer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </article>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</main>