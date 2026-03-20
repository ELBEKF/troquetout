<main class="offer-detail-wrapper py-5" aria-labelledby="offer-title">

    <header class="container mb-5">
        <nav aria-label="Fil d'Ariane" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="/" class="text-decoration-none text-muted">Accueil</a>
                </li>
                <li class="breadcrumb-item active text-primary" aria-current="page">
                    <?= htmlspecialchars($detail['titre']) ?>
                </li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold" id="offer-title">
            <?= htmlspecialchars($detail['titre']) ?>
        </h1>
        <p class="text-muted">
            <i class="bi bi-tag me-2" aria-hidden="true"></i>
            Catégorie&nbsp;: <?= htmlspecialchars($detail['categorie']) ?>
        </p>
    </header>
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="card glass-effect border-0 shadow-lg overflow-hidden card-wrap">
                    <?php if (!empty($detail['photo'])): ?>
                        <img src="<?= htmlspecialchars($detail['photo']) ?>"
                             alt="Photo de l'annonce : <?= htmlspecialchars($detail['titre']) ?>"
                             class="img-detail"
                             loading="lazy"
                             width="700" height="467">
                    <?php else: ?>
                        <div class="bg-light d-flex flex-column align-items-center justify-content-center py-5 min-h-400"
                             role="img"
                             aria-label="Aucune image disponible pour cette annonce">
                            <i class="bi bi-image text-muted display-1" aria-hidden="true"></i>
                            <span class="text-muted mt-3">Aucune image disponible</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <aside class="col-lg-5" aria-label="Informations et actions sur l'annonce">

                <div class="card glass-effect border-0 p-4 shadow-sm mb-4 card-wrap--r-lg">

                    <!-- Badges type/sens + prix -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge bg-primary-subtle text-primary rounded-pill">
                                <?= ucfirst(htmlspecialchars($detail['type'])) ?>
                            </span>
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill">
                                <?= ucfirst(htmlspecialchars($detail['sens'])) ?>
                            </span>
                        </div>
                        <span class="h3 fw-bold text-primary mb-0"
                              aria-label="Prix : <?= number_format($detail['prix'], 2) ?> euros">
                            <?= number_format($detail['prix'], 2) ?>&nbsp;€
                        </span>
                    </div>

                    <!-- Description -->
                    <section aria-labelledby="section-description">
                        <h2 class="h5 fw-bold border-bottom pb-2 mb-3" id="section-description">
                            Description
                        </h2>
                        <p class="text-muted">
                            <?= nl2br(htmlspecialchars($detail['description'])) ?>
                        </p>
                    </section>

                    <!-- Caractéristiques -->
                    <ul class="list-unstyled mb-4" aria-label="Caractéristiques de l'annonce">
                        <li class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">
                                <i class="bi bi-star me-2" aria-hidden="true"></i>État&nbsp;:
                            </span>
                            <span class="fw-bold"><?= ucfirst(htmlspecialchars($detail['etat'])) ?></span>
                        </li>
                        <li class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">
                                <i class="bi bi-shield-check me-2" aria-hidden="true"></i>Caution&nbsp;:
                            </span>
                            <span class="fw-bold"
                                  aria-label="Caution : <?= number_format($detail['caution'], 2) ?> euros">
                                <?= number_format($detail['caution'], 2) ?>&nbsp;€
                            </span>
                        </li>
                        <li class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">
                                <i class="bi bi-geo-alt me-2" aria-hidden="true"></i>Lieu&nbsp;:
                            </span>
                            <span class="fw-bold"><?= htmlspecialchars($detail['localisation']) ?></span>
                        </li>
                    </ul>

                    <!-- Offreur -->
                    <div class="offreur-card d-flex align-items-center p-3 bg-white bg-opacity-25 rounded-3 mb-4 border">
                        <div class="avatar-circle avatar-circle--sm avatar-gradient me-3 shadow-sm"
                             aria-hidden="true">
                            <?= isset($detail['user_nom'])
                                ? strtoupper(substr($detail['user_nom'], 0, 1))
                                : 'U' ?>
                        </div>
                        <div>
                            <span class="d-block small text-muted">Proposé par</span>
                            <span class="fw-bold">
                                <?= isset($detail['user_nom'])
                                    ? htmlspecialchars($detail['user_nom'])
                                    : 'Utilisateur #' . (int)$detail['user_id'] ?>
                            </span>
                        </div>
                    </div>

                    <!-- Bouton favoris -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form action="/offers/addfavoris" method="POST" class="favoris-form mb-3">
                            <input type="hidden" name="offer_id" value="<?= (int)$detail['id'] ?>">
                            <button type="submit"
                                    class="btn btn-outline-danger w-100 fw-bold shadow-sm py-2"
                                    aria-label="Ajouter « <?= htmlspecialchars($detail['titre']) ?> » à mes favoris">
                                <i class="bi bi-heart me-2" aria-hidden="true"></i>Ajouter aux favoris
                            </button>
                        </form>
                    <?php endif; ?>

                    <!-- Formulaire de contact -->
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $detail['user_id']): ?>
                        <section class="card glass-effect border-0 p-4 shadow-sm mt-3 card-wrap--r-lg"
                                 aria-labelledby="contact-heading">
                            <h2 class="h5 fw-bold mb-3" id="contact-heading">
                                <i class="bi bi-envelope-at me-2" aria-hidden="true"></i>Envoyer un message
                            </h2>
                            <form action="/send_message" method="POST"
                                  aria-label="Contacter l'offreur de cette annonce">
                                <input type="hidden" name="to_user_id" value="<?= (int)$detail['user_id'] ?>">
                                <input type="hidden" name="offer_id"   value="<?= (int)$detail['id'] ?>">

                                <!-- ✅ <label> explicite lié au textarea par for/id -->
                                <div class="mb-3">
                                    <label for="contact-message" class="form-label fw-bold small">
                                        Votre message
                                        <span class="text-danger" aria-label="champ obligatoire">*</span>
                                    </label>
                                    <textarea class="form-control"
                                              id="contact-message"
                                              name="message"
                                              rows="4"
                                              required
                                              aria-required="true"
                                              placeholder="Bonjour, votre offre m'intéresse…"></textarea>
                                </div>

                                <button type="submit"
                                        class="btn btn-primary w-100 fw-bold py-2"
                                        aria-label="Envoyer votre message à l'offreur">
                                    <i class="bi bi-send me-2" aria-hidden="true"></i>Contacter l'offreur
                                </button>
                            </form>
                        </section>

                    <?php elseif (!isset($_SESSION['user_id'])): ?>
                        <div class="alert alert-info text-center border-0 shadow-sm mt-3 card-wrap--r-lg"
                             role="status">
                            <p class="mb-2 small">Vous devez être connecté pour contacter l'offreur.</p>
                            <a href="/connexion"
                               class="btn btn-sm btn-primary px-4 fw-bold"
                               aria-label="Se connecter pour contacter l'offreur">Se connecter</a>
                        </div>
                    <?php endif; ?>

                </div>
            </aside>

        </div>
    </div>
</main>