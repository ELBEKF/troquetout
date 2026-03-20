<main id="main-content" class="requests-container py-5">

    <header class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">Demandes de la communauté</h1>
        <p class="text-muted fs-5">
            Découvrez les besoins publiés par les membres et proposez votre aide.
        </p>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="mt-4">
                <a href="/demande/create/"
                   class="btn btn-primary btn-lg shadow-sm"
                   aria-label="Publier une nouvelle demande">
                    <i class="bi bi-plus-lg me-2" aria-hidden="true"></i>Publier ma demande
                </a>
            </div>
        <?php endif; ?>
    </header>

    <?php if (empty($requests)): ?>
        <div class="alert alert-info glass-effect text-center p-5" role="alert" aria-live="polite">
            <i class="bi bi-info-circle display-4 d-block mb-3" aria-hidden="true"></i>
            <p class="mb-0">Aucune demande n'a été publiée pour le moment. Soyez le premier&nbsp;!</p>
        </div>

    <?php else: ?>
        <ul class="row g-4 list-unstyled"
            aria-label="Liste des demandes de la communauté (<?= count($requests) ?> demandes)">

            <?php foreach ($requests as $req): ?>
                <?php
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $req['user_id']) {
                    continue;
                }
                ?>
                <li class="col-md-6 col-lg-4">
                    <article class="card h-100 glass-effect border-0 shadow-sm card-wrap--r-lg"
                             aria-label="Demande : <?= htmlspecialchars($req['titre']) ?>">

                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <h2 class="h5 fw-bold mb-0">
                                    <?= htmlspecialchars($req['titre']) ?>
                                </h2>
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill small flex-shrink-0"
                                      aria-label="Type de demande : <?= htmlspecialchars($req['type_demande']) ?>">
                                    <?= ucfirst(htmlspecialchars($req['type_demande'])) ?>
                                </span>
                            </div>
                            <p class="small text-muted mt-1 mb-0">
                                <i class="bi bi-person-circle me-1" aria-hidden="true"></i>
                                Posté par
                                <span class="fw-semibold">
                                    <?= htmlspecialchars($req['prenom'] . ' ' . $req['nom']) ?>
                                </span>
                            </p>
                        </div>

                        <div class="card-body px-4">
                            <p class="small mb-1">
                                <i class="bi bi-calendar-event me-1 text-primary" aria-hidden="true"></i>
                                <span class="text-primary fw-bold">Besoin le&nbsp;:</span>
                                <time datetime="<?= htmlspecialchars($req['date_besoin']) ?>">
                                    <?= htmlspecialchars($req['date_besoin']) ?>
                                </time>
                            </p>

                            <p class="card-text text-muted line-clamp-3 mt-2">
                                <?= nl2br(htmlspecialchars($req['description'])) ?>
                            </p>
                        </div>

                        <div class="card-footer bg-transparent border-0 pb-4 px-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="/demande/proposer/<?= (int)$req['id'] ?>"
                                   class="btn btn-primary w-100 fw-bold"
                                   aria-label="Proposer mon aide pour : <?= htmlspecialchars($req['titre']) ?>">
                                    <i class="bi bi-hand-thumbs-up me-2" aria-hidden="true"></i>Proposer mon aide
                                </a>
                            <?php else: ?>
                                <a href="/connexion"
                                   class="btn btn-outline-secondary w-100"
                                   aria-label="Connectez-vous pour proposer votre aide sur cette demande">
                                    <i class="bi bi-lock-fill me-2" aria-hidden="true"></i>Connexion requise
                                </a>
                            <?php endif; ?>
                        </div>

                    </article>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>

</main>