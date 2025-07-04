<h2>Proposer une offre</h2>

<?php if (!empty($error)): ?>
    <div style="color:red"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="proposer.php" method="post">
    <input type="hidden" name="request_id" value="<?= htmlspecialchars($request_id) ?>">

    <label for="offre_id">Choisissez votre offre :</label><br>
    <select name="offre_id" id="offre_id" required>
        <option value="">-- Sélectionnez une offre --</option>
        <?php foreach ($offres as $offre): ?>
            <option value="<?= $offre['id'] ?>"><?= htmlspecialchars($offre['titre']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="message">Message :</label><br>
    <textarea name="message" id="message" required></textarea><br><br>

    <button type="submit">Envoyer</button>
</form>
