<!-- <div class="form-page"> -->
    <div class="form-container">
        <h2 class="form-title">Modifier votre offre</h2>

        <form action="/offers/modifoffer/<?php echo $modif['id']; ?>" method="POST">

            <input type="hidden" name="id" value="<?= htmlspecialchars($modif['id']) ?>">

            <!-- Titre -->
            <div class="form-group">
                <label class="form-label" for="titre">Titre <span class="form-required">*</span></label>
                <input class="form-input" type="text" name="titre" id="titre" value="<?= htmlspecialchars($modif['titre']) ?>" required>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="form-label" for="description">Description <span class="form-required">*</span></label>
                <textarea class="form-textarea" name="description" id="description" rows="4" required><?= htmlspecialchars($modif['description']) ?></textarea>
            </div>

            <!-- Sens et Type -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="sens">Sens <span class="form-required">*</span></label>
                    <select class="form-select" name="sens" id="sens" required>
                        <option value="offre" <?= $modif['sens'] === 'offre' ? 'selected' : '' ?>>Offre</option>
                        <option value="demande" <?= $modif['sens'] === 'demande' ? 'selected' : '' ?>>Demande</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="type">Type <span class="form-required">*</span></label>
                    <select class="form-select" name="type" id="type" required>
                        <option value="don" <?= $modif['type'] === 'don' ? 'selected' : '' ?>>Don</option>
                        <option value="pret" <?= $modif['type'] === 'pret' ? 'selected' : '' ?>>Prêt</option>
                        <option value="location" <?= $modif['type'] === 'location' ? 'selected' : '' ?>>Location</option>
                    </select>
                </div>
            </div>

            <!-- Catégorie et État -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="categorie">Catégorie <span class="form-required">*</span></label>
                    <input class="form-input" type="text" name="categorie" id="categorie" value="<?= htmlspecialchars($modif['categorie']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="etat">État <span class="form-required">*</span></label>
                    <select class="form-select" name="etat" id="etat" required>
                        <option value="neuf" <?= $modif['etat'] === 'neuf' ? 'selected' : '' ?>>Neuf</option>
                        <option value="bon" <?= $modif['etat'] === 'bon' ? 'selected' : '' ?>>Bon</option>
                        <option value="use" <?= $modif['etat'] === 'use' ? 'selected' : '' ?>>Utilisé</option>
                    </select>
                </div>
            </div>

            <!-- Prix et Caution -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="prix">Prix (€) <span class="form-required">*</span></label>
                    <input class="form-input" type="number" step="0.01" name="prix" id="prix" value="<?= htmlspecialchars($modif['prix']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="caution">Caution (€) <span class="form-required">*</span></label>
                    <input class="form-input" type="number" step="0.01" name="caution" id="caution" value="<?= htmlspecialchars($modif['caution']) ?>" required>
                </div>
            </div>

            <!-- Localisation et Photo -->
            <div class="form-group">
                <label class="form-label" for="localisation">Localisation <span class="form-required">*</span></label>
                <input class="form-input" type="text" name="localisation" id="localisation" value="<?= htmlspecialchars($modif['localisation']) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="photo">Photo (URL)</label>
                <input class="form-input" type="url" name="photo" id="photo" value="<?= htmlspecialchars($modif['photo']) ?>" placeholder="https://exemple.com/image.jpg">
            </div>

            <!-- Disponibilité et Statut -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="disponibilite">Disponibilité <span class="form-required">*</span></label>
                    <input class="form-input" type="date" name="disponibilite" id="disponibilite" value="<?= htmlspecialchars($modif['disponibilite']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="statut">Statut <span class="form-required">*</span></label>
                    <select class="form-select" name="statut" id="statut" required>
                        <option value="1" <?= $modif['statut'] ? 'selected' : '' ?>>Actif</option>
                        <option value="0" <?= !$modif['statut'] ? 'selected' : '' ?>>Inactif</option>
                    </select>
                </div>
            </div>

            <!-- Boutons -->
            <div class="form-buttons">
                <input type="submit" class="form-submit" value="Enregistrer les modifications">
                <button type="button" class="form-cancel" onclick="history.back()">Annuler</button>
            </div>
        </form>
    </div>
</div>
