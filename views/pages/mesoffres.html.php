
<main class="container py-5">

    <header class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
        <div class="d-flex align-items-center">
            <div class="avatar-circle avatar-circle--md avatar-gradient me-3 shadow-sm" aria-hidden="true">
                <?= isset($_SESSION['user_nom']) ? strtoupper(substr($_SESSION['user_nom'], 0, 1)) : 'E' ?>
            </div>
            <div>
                <h1 class="h2 fw-bold mb-1">Mes Annonces</h1>
                <p class="text-muted mb-0">Gérez vos objets partagés avec la communauté.</p>
            </div>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/offers/addOffer" class="btn btn-primary px-4 py-2 shadow-sm fw-bold">
                <i class="bi bi-plus-circle me-2" aria-hidden="true"></i>Ajouter une offre
            </a>
        <?php endif; ?>
    </header>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-2" aria-hidden="true"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="alert glass-effect border-0 mb-5 p-4 card-wrap--r-lg">
        <div class="d-flex">
            <i class="bi bi-lightbulb text-warning fs-3 me-3" aria-hidden="true"></i>
            <p class="mb-0 text-muted">
                <strong>Conseil :</strong> Des photos claires et des descriptions précises augmentent vos chances d'échange de <strong>40%</strong>. N'oubliez pas de retirer vos offres une fois l'échange terminé !
            </p>
        </div>
    </div>

    <?php if (empty($offers)): ?>

        <div class="card glass-effect border-0 text-center p-5 shadow-sm card-wrap">
            <i class="bi bi-box-seam display-1 text-muted mb-4 opacity-50" aria-hidden="true"></i>
            <h2 class="h4 fw-bold">Vous n'avez pas encore d'offres</h2>
            <p class="text-muted mb-4">C'est le moment de vider vos placards et de faire des heureux !</p>
            <a href="/offers/addOffer" class="btn btn-outline-primary">Publier ma première annonce</a>
        </div>

    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($offers as $offre): ?>
                <div class="col-lg-6">
                    <article class="card h-100 glass-effect border-0 shadow-sm overflow-hidden card-wrap--r-lg">
                        <div class="row g-0 h-100">

                            <div class="col-md-4">
                                <?php
                                    $imagePath = $offre['photo'] ?? '/assets/images/default-offer.png';
                                    if (!filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                        $imagePath = '/' . ltrim($imagePath, '/');
                                    }
                                ?>
                                <img src="<?= htmlspecialchars($imagePath) ?>"
                                     alt="Photo : <?= htmlspecialchars($offre['titre']) ?>"
                                     class="img-fluid img-card-left">
                            </div>

                            <div class="col-md-8 d-flex flex-column">
                                <div class="card-body p-4">

                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h3 class="h5 fw-bold mb-0 text-truncate">
                                            <?= htmlspecialchars($offre['titre']) ?>
                                        </h3>
                                        <span class="badge bg-primary-subtle text-primary rounded-pill ms-2">
                                            <?= ucfirst(htmlspecialchars($offre['type'])) ?>
                                        </span>
                                    </div>

                                    <p class="small text-muted mb-2">
                                        <i class="bi bi-calendar3 me-1" aria-hidden="true"></i>
                                        Publiée le <?= date('d/m/Y', strtotime($offre['date_creation'] ?? 'now')) ?>
                                    </p>

                                    <p class="small text-muted mb-2">
                                        <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>
                                        <?= htmlspecialchars($offre['localisation']) ?>
                                    </p>

                                    <?php if ($offre['statut'] == 1): ?>
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="bi bi-eye me-1" aria-hidden="true"></i>Actif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            <i class="bi bi-eye-slash me-1" aria-hidden="true"></i>Brouillon
                                        </span>
                                    <?php endif; ?>

                                </div>

                                <div class="card-footer bg-transparent border-0 p-4 pt-0 mt-auto">
                                    <div class="d-flex gap-2">
                                        <a href="/offers/modifoffer/<?= (int)$offre['id'] ?>"
                                           class="btn btn-sm btn-warning flex-grow-1 fw-bold">
                                            <i class="bi bi-pencil-square me-1" aria-hidden="true"></i>Modifier
                                        </a>
                                        <a href="/offers/delete/<?= $offre['id'] ?>"
                                           class="btn btn-sm btn-outline-danger flex-grow-1 fw-bold"
                                           data-confirm="Supprimer définitivement cette offre ?">
                                            <i class="bi bi-trash me-1" aria-hidden="true"></i>Supprimer
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</main>