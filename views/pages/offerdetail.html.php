<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<article class="offer-detail-wrapper" aria-labelledby="offer-title">

    <!-- ── En-tête ──────────────────────────────────────────────────────── -->
    <header class="offer-detail-header">
        <h1 class="offer-detail-title" id="offer-title">
            <?= htmlspecialchars($detail['titre']) ?>
        </h1>
        <p class="offer-detail-subtitle">Découvrez tous les détails de cette offre</p>
    </header>

    <!-- ── Contenu principal : image + infos ────────────────────────────── -->
    <div class="offer-detail-grid">

        <!-- Image -->
        <div class="offer-detail-image-wrap">
            <?php if (!empty($detail['photo'])): ?>
                <img
                    src="<?= htmlspecialchars($detail['photo']) ?>"
                    alt="Photo de l'offre : <?= htmlspecialchars($detail['titre']) ?>"
                    class="offer-detail-img"
                    loading="lazy"
                >
            <?php else: ?>
                <div class="offer-detail-no-image" role="img" aria-label="Aucune image disponible">
                    <svg aria-hidden="true" width="48" height="48" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                    <span>Aucune image disponible</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Infos -->
        <div class="offer-detail-info">

            <!-- Badges type / sens -->
            <div class="offer-detail-badges">
                <span class="badge-type"><?= htmlspecialchars($detail['type']) ?></span>
                <span class="badge-sens"><?= htmlspecialchars($detail['sens']) ?></span>
                <span class="badge-etat badge-etat--<?= htmlspecialchars($detail['etat']) ?>">
                    <?= htmlspecialchars($detail['etat']) ?>
                </span>
            </div>

            <!-- Description -->
            <section aria-labelledby="desc-title">
                <h2 class="offer-detail-section-title" id="desc-title">Description</h2>
                <p class="offer-detail-description">
                    <?= nl2br(htmlspecialchars($detail['description'])) ?>
                </p>
            </section>

            <!-- Grille de détails -->
            <dl class="offer-detail-dl">
                <div class="offer-detail-dl-item">
                    <dt>Catégorie</dt>
                    <dd><?= htmlspecialchars($detail['categorie']) ?></dd>
                </div>
                <div class="offer-detail-dl-item">
                    <dt>Prix</dt>
                    <dd class="offer-detail-price"><?= number_format($detail['prix'], 2) ?> €</dd>
                </div>
                <div class="offer-detail-dl-item">
                    <dt>Caution</dt>
                    <dd><?= number_format($detail['caution'], 2) ?> €</dd>
                </div>
                <div class="offer-detail-dl-item">
                    <dt>Localisation</dt>
                    <dd>
                        <svg aria-hidden="true" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <?= htmlspecialchars($detail['localisation']) ?>
                    </dd>
                </div>
                <div class="offer-detail-dl-item">
                    <dt>Disponibilité</dt>
                    <dd><?= htmlspecialchars($detail['disponibilite']) ?></dd>
                </div>
                <div class="offer-detail-dl-item">
                    <dt>Publiée le</dt>
                    <dd><?= date('d/m/Y', strtotime($detail['date_creation'])) ?></dd>
                </div>
            </dl>

        </div>
    </div>

    <!-- ── Formulaire de contact ─────────────────────────────────────────── -->
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $detail['user_id']): ?>
        <section class="offer-detail-contact" aria-labelledby="contact-title">
            <h2 class="offer-detail-section-title" id="contact-title">Contacter l'offreur</h2>

            <div class="form-container" style="max-width: 100%;">
                <form class="form" action="/send_message/" method="POST">
                    <input type="hidden" name="to_user_id" value="<?= (int)$detail['user_id'] ?>">
                    <input type="hidden" name="offer_id"   value="<?= (int)$detail['id'] ?>">

                    <div class="form-group">
                        <label class="form-label" for="message-field">
                            Votre message <span class="form-required">*</span>
                        </label>
                        <textarea
                            class="form-textarea"
                            id="message-field"
                            name="message"
                            required
                            placeholder="Bonjour, je suis intéressé(e) par votre offre..."
                            rows="5"
                            aria-describedby="message-hint"
                        ></textarea>
                        <span class="form-info" id="message-hint">
                            Votre message sera envoyé directement à l'offreur.
                        </span>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="form-submit">
                            <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="22" y1="2" x2="11" y2="13"/>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                            </svg>
                            Envoyer le message
                        </button>
                        <button type="button" class="form-cancel" onclick="history.back()">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </section>
    <?php elseif (!isset($_SESSION['user_id'])): ?>
        <div class="request-alert" role="status">
            <p>
                <a href="/connexion" class="btn-connexion">Connectez-vous</a>
                pour contacter l'offreur.
            </p>
        </div>
    <?php endif; ?>

</article>