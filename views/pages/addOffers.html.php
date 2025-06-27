<div class="container">

    <h2>Créer une nouvelle offre</h2>

    <form action="addoffer.php" method="POST">

        <label for="titre">Titre :</label>
        <input type="text" name="titre" id="titre" required><br><br>

        <label for="description">Description :</label><br>
        <textarea name="description" id="description" rows="4" cols="50" required></textarea><br><br>

        <label for="sens">Sens :</label>
        <select name="sens" id="sens" required>
            <option value="offre">Offre</option>
            <option value="demande">Demande</option>
        </select><br><br>

        <label for="type">Type :</label>
        <select name="type" id="type" required>
            <option value="don">Don</option>
            <option value="pret">Prêt</option>
            <option value="location">Location</option>
        </select><br><br>

        <label for="categorie">Catégorie :</label>
        <input type="text" name="categorie" id="categorie" required><br><br>

        <label for="etat">État :</label>
        <select name="etat" id="etat" required>
            <option value="neuf">Neuf</option>
            <option value="bon">Bon</option>
            <option value="use">Utilisé</option>
        </select><br><br>

        <label for="prix">Prix (€) :</label>
        <input type="number" step="0.01" name="prix" id="prix" required><br><br>

        <label for="caution">Caution (€) :</label>
        <input type="number" step="0.01" name="caution" id="caution" required><br><br>

        <label for="localisation">Localisation :</label>
        <input type="text" name="localisation" id="localisation" required><br><br>

        <label for="photo">Photo (URL) :</label>
        <input type="url" name="photo" id="photo" placeholder="https://exemple.com/image.jpg"><br><br>

        <label for="disponibilite">Disponibilité :</label>
        <input type="date" name="disponibilite" id="disponibilite" required><br><br>

        <label for="statut">Statut :</label>
        <select name="statut" id="statut" required>
            <option value="1">Actif</option>
            <option value="0">Inactif</option>
        </select><br><br>

        <input type="submit" value="Ajouter l'offre">
    </form>

</div>