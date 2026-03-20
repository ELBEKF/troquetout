<?php

$search       = $search       ?? '';
$type         = $type         ?? '';
$localisation = $localisation ?? '';
?>

<main id="main-content">

<header class="hero-section text-center py-5 mb-5">
    <div class="container">
        <h1 class="display-3 fw-bold text-gradient">L'avenir du partage commence ici</h1>
        <p class="lead text-muted mx-auto hero-lead">
            Découvrez une plateforme moderne de partage et d'échange. Donnez, louez ou prêtez simplement vos objets au sein de votre communauté.
        </p>
    </div>
</header>

<div class="container">
    <section class="search-bar-wrapper mb-5" aria-labelledby="search-heading">
        <h2 id="search-heading" class="visually-hidden">Rechercher une offre</h2>

        <form id="search-form" method="GET" class="card glass-effect p-4 border-0 shadow-sm" role="search" aria-label="Formulaire de recherche d'offres">
            <div class="row g-3 align-items-end">

                <div class="col-lg-4">
                    <label for="search" class="form-label fw-bold small">Quoi ?</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0" aria-hidden="true">
                            <i class="bi bi-search" aria-hidden="true"></i>
                        </span>
                        <input type="search" name="search" id="search"
                               class="form-control border-start-0"
                               placeholder="Nom de l'objet..."
                               value="<?= htmlspecialchars($search) ?>"
                               aria-label="Rechercher par nom d'objet"
                               autocomplete="off">
                    </div>
                </div>

                <div class="col-lg-3">
                    <label for="type" class="form-label fw-bold small">Type d'échange</label>
                    <select name="type" id="type" class="form-select" aria-label="Filtrer par type d'échange">
                        <option value="">Tous les types</option>
                        <option value="don"      <?= ($type === 'don')      ? 'selected' : '' ?>>Don</option>
                        <option value="location" <?= ($type === 'location') ? 'selected' : '' ?>>Location</option>
                        <option value="pret"     <?= ($type === 'pret')     ? 'selected' : '' ?>>Prêt</option>
                    </select>
                </div>

                <div class="col-lg-3">
                    <label for="localisation" class="form-label fw-bold small">Où ?</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0" aria-hidden="true">
                            <i class="bi bi-geo-alt" aria-hidden="true"></i>
                        </span>
                        <input type="text" name="localisation" id="localisation"
                               class="form-control border-start-0"
                               placeholder="Ville..."
                               value="<?= htmlspecialchars($localisation) ?>"
                               aria-label="Filtrer par ville ou localisation"
                               autocomplete="off">
                    </div>
                </div>

                <div class="col-lg-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2" aria-label="Lancer la recherche">
                        Trouver
                    </button>
                </div>

            </div>
        </form>
    </section>

    <section class="offers-section" aria-labelledby="offers-heading">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 id="offers-heading" class="h3 fw-bold mb-0">Les dernières offres</h2>
            <span class="badge bg-primary-subtle text-primary rounded-pill" id="offers-count" aria-live="polite">
                <?= count($offers) ?> annonce<?= count($offers) > 1 ? 's' : '' ?>
            </span>
        </div>

        <div id="offers-grid">
            <?php if (empty($offers)): ?>
                <div class="text-center py-5 card glass-effect">
                    <i class="bi bi-emoji-frown display-1 text-muted mb-3" aria-hidden="true"></i>
                    <p class="fs-4 text-muted">Désolé, aucune offre ne correspond à votre recherche.</p>
                    <a href="/" class="btn btn-outline-primary">Réinitialiser les filtres</a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($offers as $offer): ?>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <article class="card h-100 glass-effect border-0 shadow-hover overflow-hidden">

                                <div class="position-relative">
                                    <img src="<?= htmlspecialchars($offer['photo']) ?>"
                                         class="card-img-top offer-img"
                                         alt="<?= htmlspecialchars($offer['titre']) ?> — <?= htmlspecialchars($offer['etat'] ?? '') ?> à <?= htmlspecialchars($offer['localisation']) ?>"
                                         loading="lazy">
                                    <span class="badge bg-primary position-absolute top-0 end-0 m-3 shadow-sm"
                                          aria-label="Type : <?= ucfirst(htmlspecialchars($offer['type'])) ?>">
                                        <?= ucfirst(htmlspecialchars($offer['type'])) ?>
                                    </span>
                                </div>

                                <div class="card-body p-4">
                                    <h3 class="h5 card-title fw-bold mb-2">
                                        <?= htmlspecialchars($offer['titre']) ?>
                                    </h3>
                                    <p class="small text-muted mb-3">
                                        <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>
                                        <?= htmlspecialchars($offer['localisation']) ?>
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <a href="/offers/detail/<?= (int)$offer['id'] ?>"
                                           class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold"
                                           aria-label="Voir les détails de l'offre : <?= htmlspecialchars($offer['titre']) ?>">
                                            Voir les détails
                                        </a>

                                        <?php if (isset($_SESSION['user_id'])): ?>
                                            <?php $isFavori = (isset($offer['is_favori']) && $offer['is_favori'] == 1); ?>
                                            <form action="/offers/addfavoris" method="POST" class="m-0">
                                                <input type="hidden" name="offer_id" value="<?= $offer['id'] ?>">
                                                <button type="submit"
                                                        class="btn <?= $isFavori ? 'btn-danger' : 'btn-outline-danger' ?> btn-sm rounded-circle p-2 shadow-sm"
                                                        aria-label="<?= $isFavori ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>"
                                                        title="<?= $isFavori ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>">
                                                    <i class="bi <?= $isFavori ? 'bi-heart-fill' : 'bi-heart' ?>" aria-hidden="true"></i>
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
        </div>
    </section>

</div>

</main>