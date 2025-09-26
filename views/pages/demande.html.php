<h2 class="request-title text-center">Liste des demandes</h2>

<p class="explique">
  Retrouvez ici toutes les demandes publiées par les membres de la communauté.<br>
  Si quelqu’un recherche un objet que vous possédez, c’est l’occasion idéale pour proposer un échange.<br>
  Parcourez la liste, utilisez les filtres pour affiner vos résultats et saisissez l’opportunité de troquer en toute simplicité.
</p>
<br>
<?php if (isset($_SESSION['user_id'])): ?>
    <a href="/demande/create/" class="btn btn-primary mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
        </svg>
        Ajouter une demande
    </a>
<?php else: ?>
    <div class="request-alert">
        <p class="pdemande">Connectez-vous ou inscrivez-vous pour ajouter ou répondre à des demandes.</p>
        <br>
        <a href="/connexion" class="btn btn-primary">Connexion</a>
        <a href="/inscription" class="btn btn-success ms-2">Inscription</a>
        <br>
        <br>

    </div>
<?php endif; ?>
<br>

<?php foreach ($requests as $req): ?>
    <div class="request-card">
        <h3 class="request-card-title"><?= htmlspecialchars($req['titre']) ?></h3>
        <p class="request-author"><?= htmlspecialchars($req['prenom'] . ' ' . $req['nom']) ?></p>
        <p><strong>Type :</strong> <?= htmlspecialchars($req['type_demande']) ?></p>
        <p><strong>Besoin le :</strong> <?= htmlspecialchars($req['date_besoin']) ?></p>
        <p class="request-description"><?= nl2br(htmlspecialchars($req['description'])) ?></p>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/demande/proposer/<?= $req['id'] ?>" class="btn btn-primary">
    Proposer une offre
</a>

        <?php else: ?>
            <p class="request-locked">🔒 Connectez-vous ou inscrivez-vous pour proposer une offre.</p>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $req['user_id']): ?>
            
            
            <form action="/deletedemande/<?= $req['id'] ?>" method="post" class="request-delete-form">
                    <a href="/demande/editdemande/<?= $req['id'] ?>" class="btn btn-warning btn-sm mt-2">Modifier</a>
    <button type="submit" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Confirmer la suppression ?')">
        Supprimer
    </button>
</form>

            
        <?php endif; ?>
    </div>
<?php endforeach; ?>
