<div class="container">
    <h2>Modifier votre offre</h2>

    <form action="modifOffer.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($modif['id']) ?>">

        <label for="titre">Titre :</label>
        <input type="text" name="titre" id="titre" value="<?= htmlspecialchars($modif['titre']) ?>" required><br><br>

        <label for="description">Description :</label><br>
        <textarea name="description" id="description" rows="4" cols="50" required><?= htmlspecialchars($modif['description']) ?></textarea><br><br>

        <label for="sens">Sens :</label>
        <select name="sens" id="sens" required>
            <option value="offre" <?= $modif['sens'] === 'offre' ? 'selected' : '' ?>>Offre</option>
            <option value="demande" <?= $modif['sens'] === 'demande' ? 'selected' : '' ?>>Demande</option>
        </select><br><br>

        <label for="type">Type :</label>
        <select name="type" id="type" required>
            <option value="don" <?= $modif['type'] === 'don' ? 'selected' : '' ?>>Don</option>
            <option value="pret" <?= $modif['type'] === 'pret' ? 'selected' : '' ?>>Prêt</option>
            <option value="location" <?= $modif['type'] === 'location' ? 'selected' : '' ?>>Location</option>
        </select><br><br>

        <label for="categorie">Catégorie :</label>
        <input type="text" name="categorie" id="categorie" value="<?= htmlspecialchars($modif['categorie']) ?>" required><br><br>

        <label for="etat">État :</label>
        <select name="etat" id="etat" required>
            <option value="neuf" <?= $modif['etat'] === 'neuf' ? 'selected' : '' ?>>Neuf</option>
            <option value="bon" <?= $modif['etat'] === 'bon' ? 'selected' : '' ?>>Bon</option>
            <option value="use" <?= $modif['etat'] === 'use' ? 'selected' : '' ?>>Utilisé</option>
        </select><br><br>

        <label for="prix">Prix (€) :</label>
        <input type="number" step="0.01" name="prix" id="prix" value="<?= htmlspecialchars($modif['prix']) ?>" required><br><br>

        <label for="caution">Caution (€) :</label>
        <input type="number" step="0.01" name="caution" id="caution" value="<?= htmlspecialchars($modif['caution']) ?>" required><br><br>

        <label for="localisation">Localisation :</label>
        <input type="text" name="localisation" id="localisation" value="<?= htmlspecialchars($modif['localisation']) ?>" required><br><br>

        <label for="photo">Photo (URL) :</label>
        <input type="url" name="photo" id="photo" value="<?= htmlspecialchars($modif['photo']) ?>"><br><br>

        <label for="disponibilite">Disponibilité :</label>
        <input type="date" name="disponibilite" id="disponibilite" value="<?= htmlspecialchars($modif['disponibilite']) ?>" required><br><br>

        <label for="statut">Statut :</label>
        <select name="statut" id="statut" required>
            <option value="1" <?= $modif['statut'] ? 'selected' : '' ?>>Actif</option>
            <option value="0" <?= !$modif['statut'] ? 'selected' : '' ?>>Inactif</option>
        </select><br><br>

        <input type="submit" value="Modifier l'offre">
    </form>
</div>
