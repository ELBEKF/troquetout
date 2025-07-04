<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Modifier Utilisateur</title>
</head>
<body>
    <h1>Modifier l'utilisateur</h1>

    <?php if (!empty($error)) : ?>
        <div style="color: red;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="modifUser.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>" />

        <label for="nom">Nom :</label><br />
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required /><br /><br />

        <label for="prenom">Prénom :</label><br />
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required /><br /><br />

        <label for="email">Email :</label><br />
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required /><br /><br />

        <label for="telephone">Téléphone :</label><br />
        <input type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($user['telephone'] ?? '') ?>" /><br /><br />

        <label for="ville">Ville :</label><br />
        <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($user['ville'] ?? '') ?>" /><br /><br />

        <label for="code_postal">Code Postal :</label><br />
        <input type="text" id="code_postal" name="code_postal" value="<?= htmlspecialchars($user['code_postal'] ?? '') ?>" /><br /><br />

        <!-- Si tu veux modifier le mot de passe, ajoute un champ ici (optionnel) -->

        <button type="submit">Modifier</button>
    </form>

    <p><a href="/admin.php">Retour au tableau de bord</a></p>
</body>
</html>
