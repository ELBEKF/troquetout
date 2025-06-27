<h2><?= htmlspecialchars($title) ?></h2>

<?php if (empty($offers)): ?>
    <p>Vous n'avez publié aucune offre pour le moment.</p>
<?php else: ?>
    <?php foreach ($offers as $offre): ?>
        <div style="border: 1px solid #ccc; margin-bottom: 15px; padding: 10px;">
            <strong><?= htmlspecialchars($offre['titre']) ?></strong><br>
            Type: <?= htmlspecialchars($offre['type_offre']) ?><br>
            Publiée le: <?= htmlspecialchars($offre['date_creation']) ?><br>
            <p><?= nl2br(htmlspecialchars($offre['description'])) ?></p>

            <!-- Boutons d'action -->
            <a href="modiOffer.php?id=<?= $offre['id'] ?>">Modifier</a> |
            <a href="deleteOffer.php?id=<?= $offre['id'] ?>" onclick="return confirm('Supprimer cette offre ?');">Supprimer</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
