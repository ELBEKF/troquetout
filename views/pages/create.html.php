<!-- <div class="form-page">     -->
    <div class="form-container">
        <h2 class="form-title">Créer une nouvelle demande</h2>

        <form class="form" action="create" method="POST">
            <!-- Titre -->
            <div class="form-group">
                <label class="form-label" for="titre">Titre <span class="form-required">*</span></label>
                <input class="form-input" type="text" id="titre" name="titre" required placeholder="Ex: Recherche vélo pour le week-end">
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="form-label" for="description">Description <span class="form-required">*</span></label>
                <textarea class="form-textarea" id="description" name="description" required placeholder="Décrivez votre besoin en quelques mots..."></textarea>
            </div>

            <!-- Type + Date de besoin -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="type">Type de demande <span class="form-required">*</span></label>
                    <select class="form-select" id="type_demande" name="type_demande" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="pret">Prêt</option>
                        <option value="don">Don</option>
                        <option value="location">Location</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="date_besoin">Date de besoin <span class="form-required">*</span></label>
                    <input class="form-input" type="date" id="date_besoin" name="date_besoin" required>
                </div>
            </div>

            <!-- Localisation -->
            <div class="form-group">
                <label class="form-label" for="localisation">Localisation <span class="form-required">*</span></label>
                <input class="form-input" type="text" id="localisation" name="localisation" required>
            </div>

            <!-- URL image optionnelle (illustration) -->
            <div class="form-group">
                <label class="form-label" for="photo">Photo (URL)</label>
                <input class="form-input" type="url" id="photo" name="photo" placeholder="https://exemple.com/image.jpg">
            </div>

            <!-- Boutons -->
            <div class="form-buttons">
                <input class="form-submit" type="submit" value="Envoyer la demande">
                <button class="form-cancel" type="button" onclick="history.back()">Annuler</button>
            </div>
        </form>
    </div>
</div>
