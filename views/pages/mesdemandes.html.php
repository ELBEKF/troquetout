<link rel="stylesheet" href="/css/mesdemandes.css">
<!-- SVG Gradient for icon -->
<svg width="0" height="0">
  <defs>
    <linearGradient id="gradient-svg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#00fff5;stop-opacity:1" />
      <stop offset="50%" style="stop-color:#8b5cf6;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#ec4899;stop-opacity:1" />
    </linearGradient>
  </defs>
</svg>

<div class="requests-container">
    <h2 class="request-title">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-raised-hand" viewBox="0 0 16 16">
            <path d="M6 6.207v9.043a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H6.236a1 1 0 0 1-.447-.106l-.33-.165A.83.83 0 0 1 5 2.488V.75a.75.75 0 0 0-1.5 0v2.083c0 .715.404 1.37 1.044 1.689L5.5 5c.32.32.5.754.5 1.207"/>
            <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
        </svg>
        <?= htmlspecialchars($title) ?>
    </h2>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="add-request-wrapper">
            <a href="/demande/create/" class="btn btn-primary btn-add">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                Ajouter une demande
            </a>
        </div>
    <?php else: ?>
        <div class="request-alert">
            <p class="pdemande">Connectez-vous ou inscrivez-vous pour ajouter ou répondre à des demandes.</p>
            <div class="auth-buttons">
                <a href="/connexion" class="btn-connexion">Connexion</a>
                <a href="/inscription" class="btn btn-success ms-2">Inscription</a>
            </div>
        </div>
    <?php endif; ?>

    <p class="explique">
        Suivez vos demandes en cours et gardez-les à jour.<br>
        Plus vos descriptions sont précises, plus vous attirerez des propositions pertinentes.<br>
        N'hésitez pas à ajuster vos recherches pour optimiser vos échanges.
    </p>

    <?php if (empty($requests)): ?>
        <div class="request-alert">
            Vous n'avez publié aucune demande pour le moment.
        </div>
    <?php else: ?>
        <div class="requests-grid">
            <?php foreach ($requests as $req): ?>
                <div class="request-card">
                    <div class="request-card-header">
                        <h3 class="request-card-title"><?= htmlspecialchars($req['titre']) ?></h3>
                        <span class="request-type-badge <?= ($req['type_demande'] === 'don') ? 'normal' : 'urgent' ?>">
                            <?= strtoupper(htmlspecialchars($req['type_demande'])) ?>
                        </span>
                    </div>

                    <?php if (!empty($req['auteur'])): ?>
                        <div class="request-author"><?= htmlspecialchars($req['auteur']) ?></div>
                    <?php endif; ?>

                    <p class="request-date"><strong>Besoin le :</strong> <?= htmlspecialchars($req['date_besoin']) ?></p>
                    <div class="request-description"><?= nl2br(htmlspecialchars($req['description'])) ?></div>

                    <div class="request-actions">
                        <div class="action-buttons">
                            <!-- Formulaire de suppression -->
                            <form action="/deletedemande/<?= $req['id'] ?>" method="post" onsubmit="return confirm('Confirmer la suppression ?');">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                            
                            <!-- Lien de modification -->
                            <a href="/demande/editdemande/<?= $req['id'] ?>" class="btn btn-warning btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                                </svg>
                                Modifier
                            </a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>