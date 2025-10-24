<link rel="stylesheet" href="/css/addoffer.css">

<!-- <link rel="stylesheet" href="./css/header.css"> -->


<div class="form-container">
    <h2 class="form-title">Créer une nouvelle offre</h2>

    <!-- ⚠️ enctype DOIT être sur le <form>, pas dans un <div> -->
    <form class="form" action="addOffer" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label class="form-label" for="titre">Titre <span class="form-required">*</span></label>
            <input class="form-input" type="text" name="titre" id="titre" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Description <span class="form-required">*</span></label>
            <textarea class="form-textarea" name="description" id="description" required></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="sens">Sens <span class="form-required">*</span></label>
                <select class="form-select" name="sens" id="sens" required>
                    <option value="offre">Offre</option>
                    <option value="demande">Demande</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="type">Type <span class="form-required">*</span></label>
                <select class="form-select" name="type" id="type" required>
                    <option value="don">Don</option>
                    <option value="pret">Prêt</option>
                    <option value="location">Location</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="categorie">Catégorie <span class="form-required">*</span></label>
                <input class="form-input" type="text" name="categorie" id="categorie" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="etat">État <span class="form-required">*</span></label>
                <select class="form-select" name="etat" id="etat" required>
                    <option value="neuf">Neuf</option>
                    <option value="bon">Bon</option>
                    <option value="use">Utilisé</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="prix">Prix (€) <span class="form-required">*</span></label>
                <input class="form-input" type="number" step="0.01" name="prix" id="prix" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="caution">Caution (€) <span class="form-required">*</span></label>
                <input class="form-input" type="number" step="0.01" name="caution" id="caution" required>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="localisation">Localisation <span class="form-required">*</span></label>
            <input class="form-input" type="text" name="localisation" id="localisation" required>
        </div>

        <!-- ✅ Ici, le champ pour importer une image -->
        <div class="form-group">
            <label class="form-label" for="photo">Photo</label>
            <input class="form-input" type="file" name="photo" id="photo" accept="image/*" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="disponibilite">Disponibilité <span class="form-required">*</span></label>
                <input class="form-input" type="date" name="disponibilite" id="disponibilite" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="statut">Statut <span class="form-required">*</span></label>
                <select class="form-select" name="statut" id="statut" required>
                    <option value="1">Actif</option>
                    <option value="0">Inactif</option>
                </select>
            </div>
        </div>

        <div class="form-buttons">
            <input type="submit" value="Ajouter l'offre" class="form-submit">
            <button type="button" class="form-cancel" onclick="history.back()">Annuler</button>
        </div>

    </form>
</div>
