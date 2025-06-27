<div class="container my-5">
    <h2>Inscription</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="inscription.php" method="POST">

        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required><br><br>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required><br><br>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="telephone">Téléphone :</label>
        <input type="tel" name="telephone" id="telephone"><br><br>

        <label for="ville">Ville :</label>
        <input type="text" name="ville" id="ville"><br><br>

        <label for="code_postal">Code postal :</label>
        <input type="text" name="code_postal" id="code_postal"><br><br>

        <input type="submit" value="S'inscrire" class="btn btn-primary">

    </form>
</div>
