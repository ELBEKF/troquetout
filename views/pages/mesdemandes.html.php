<h2><?= htmlspecialchars($title) ?></h2>

<?php if (empty($requests)): ?>
    <p>Vous n'avez publié aucune demande pour le moment.</p>
<?php else: ?>
    <?php foreach ($requests as $req): ?>
        <div style="border: 1px solid #ccc; margin-bottom: 15px; padding: 10px;">
            <strong><?= htmlspecialchars($req['titre']) ?></strong><br>
            Type: <?= htmlspecialchars($req['type_demande']) ?><br>
            Besoin le: <?= htmlspecialchars($req['date_besoin']) ?><br>
            <p><?= nl2br(htmlspecialchars($req['description'])) ?></p>

            <!-- Boutons d'action -->
            <a href="editdemande.php?id=<?= $req['id'] ?>">Modifier</a> |
            <a href="deletedemande.php?id=<?= $req['id'] ?>" onclick="return confirm('Supprimer cette demande ?');">Supprimer</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
