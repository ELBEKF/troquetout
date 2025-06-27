<h2>Liste des demandes</h2>

<a href="/create.php" class="btn btn-primary mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
        </svg>
        Ajouter une demande
    </a>

<?php foreach ($requests as $req): ?>
    <div style="border: 1px solid #ccc; margin-bottom: 15px; padding: 10px;">
        <strong><?= htmlspecialchars($req['titre']) ?></strong><br>
        <em><?= htmlspecialchars($req['prenom'] . ' ' . $req['nom']) ?></em><br>
        Type: <?= htmlspecialchars($req['type_demande']) ?><br>
        Besoin le: <?= $req['date_besoin'] ?><br>
        <p><?= nl2br(htmlspecialchars($req['description'])) ?></p>

        <!-- Bouton Proposer -->
        <form action="proposition.php" method="post" style="margin-top: 10px;">
            <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
            <button type="submit">Proposer</button>
        </form>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $req['user_id']): ?>
    <!-- Bouton Modifier -->
    <a href="editdemande.php?id=<?= $req['id'] ?>" class="btn btn-warning btn-sm" style="margin-right: 5px;">
        Modifier
    </a>

    <!-- Formulaire Supprimer -->
    <form action="deletedemande.php" method="post" style="display:inline;">
        <input type="hidden" name="id" value="<?= $req['id'] ?>">
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">
            Supprimer
        </button>
    </form>
<?php endif; ?>

    </div>
<?php endforeach; ?>

