<link rel="stylesheet" href="/css/mesdemandes.css">
<div class="requests-container">
    <h2 class="request-title"><?= htmlspecialchars($title) ?></h2>

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
        N’hésitez pas à ajuster vos recherches pour optimiser vos échanges.
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
                Supprimer
            </button>
        </form>
        
        <!-- Lien de modification -->
        <a href="/demande/editdemande/<?= $req['id'] ?>" class="btn btn-warning btn-sm">
            Modifier
        </a>
    </div>
</div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
