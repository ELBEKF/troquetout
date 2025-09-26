<!-- <div class="form-page"> -->
    <div class="form-container">
        <h2 class="form-title">Modifier l'utilisateur</h2>

        <?php if (!empty($error)) : ?>
            <p class="form-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        

        <form class="form" method="POST" action="/admin/modifUser/<?= $user['id'] ?>">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

            <!-- Nom + Prénom -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="nom">Nom <span class="form-required">*</span></label>
                    <input class="form-input" type="text" name="nom" id="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="prenom">Prénom <span class="form-required">*</span></label>
                    <input class="form-input" type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" required>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="email">Email <span class="form-required">*</span></label>
                <input class="form-input" type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
            </div>

            <!-- Téléphone -->
            <div class="form-group">
                <label class="form-label" for="telephone">Téléphone</label>
                <input class="form-input" type="text" name="telephone" id="telephone" value="<?= htmlspecialchars($user['telephone'] ?? '') ?>">
            </div>

            <!-- Ville + Code Postal -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="ville">Ville</label>
                    <input class="form-input" type="text" name="ville" id="ville" value="<?= htmlspecialchars($user['ville'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="code_postal">Code postal</label>
                    <input class="form-input" type="text" name="code_postal" id="code_postal" value="<?= htmlspecialchars($user['code_postal'] ?? '') ?>">
                </div>
            </div>

            <!-- Informations admin -->
            <div class="form-group">
                <div class="admin-info">
                    <p><strong>ID utilisateur :</strong> <?= htmlspecialchars($user['id']) ?></p>
                    <p><strong>Rôle :</strong> <?= htmlspecialchars($user['role'] ?? 'user') ?></p>
                    <p><strong>Date d'inscription :</strong> <?= htmlspecialchars($user['date_inscription'] ?? 'Non disponible') ?></p>
                </div>
            </div>

            <!-- Boutons -->
            <div class="form-buttons">
                <button type="submit" class="form-submit">Mettre à jour l'utilisateur</button>
                <a href="/admin" class="form-cancel">Retour au dashboard</a>
            </div>
        </form>
    </div>
</div>