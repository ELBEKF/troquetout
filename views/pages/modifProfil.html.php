<h1>Modifier mon profil</h1>

<?php if (!empty($error)) : ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id'] ?? '') ?>">

    <label>Nom :</label>
    <input type="text" name="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>" required><br>

    <label>Prénom :</label>
    <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" required><br>

    <label>Email :</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required><br>

    <label>Téléphone :</label>
    <input type="text" name="telephone" value="<?= htmlspecialchars($user['telephone'] ?? '') ?>"><br>

    <label>Ville :</label>
    <input type="text" name="ville" value="<?= htmlspecialchars($user['ville'] ?? '') ?>"><br>

    <label>Code postal :</label>
    <input type="text" name="code_postal" value="<?= htmlspecialchars($user['code_postal'] ?? '') ?>"><br>

    <button type="submit">Mettre à jour</button>
</form>
