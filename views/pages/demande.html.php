<link rel="stylesheet" href="/css/mesdemandes.css">

<section class="requests-container">

    <header class="text-center mb-5">
        <h2 class="form-title"> Demandes de la communauté</h2>
        <p class="subtitle">Découvrez les besoins publiés par les autres membres.</p>
    </header>
<?php if (isset($_SESSION['user_id'])): ?>
        <div class="add-request-wrapper">
            <a href="/demande/create/" class="btn btn-primary mb-4 btn-add">
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
    <div class="requests-grid">
        <?php foreach ($requests as $req): ?>
            <?php 
            // Si l'utilisateur est connecté et que c'est sa propre demande, on ignore
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $req['user_id']) {
                continue;
            }
            ?>
            <div class="request-card">
                <div class="card-header">
                    <h3><?= htmlspecialchars($req['titre']) ?></h3>
                    <span class="author">@<?= htmlspecialchars($req['prenom'] . ' ' . $req['nom']) ?></span>
                </div>
                <div class="card-body">
                    <p><strong>Type :</strong> <?= htmlspecialchars($req['type_demande']) ?></p>
                    <p><strong>Besoin le :</strong> <?= htmlspecialchars($req['date_besoin']) ?></p>
                    <p class="desc"><?= nl2br(htmlspecialchars($req['description'])) ?></p>
                </div>
                <div class="card-footer">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/demande/proposer/<?= $req['id'] ?>" class="btn-action offer">Proposer une offre</a>
                    <?php else: ?>
                        <p class="locked">🔒 Connectez-vous pour proposer une offre</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
