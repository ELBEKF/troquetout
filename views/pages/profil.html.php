<!-- <div class="form-page"> -->
    <div class="form-container">
        <h2 class="form-title"><?= htmlspecialchars($title) ?></h2>

        <div class="profil-info">
            <ul class="form-summary">
                <li><strong>Nom :</strong> <?= htmlspecialchars($profil['nom']) ?></li>
                <li><strong>Prénom :</strong> <?= htmlspecialchars($profil['prenom']) ?></li>
                <li><strong>Email :</strong> <?= htmlspecialchars($profil['email']) ?></li>
                <li><strong>Téléphone :</strong> <?= htmlspecialchars($profil['telephone']) ?></li>
                <li><strong>Ville :</strong> <?= htmlspecialchars($profil['ville']) ?></li>
                <li><strong>Code postal :</strong> <?= htmlspecialchars($profil['code_postal']) ?></li>
                <li><strong>Inscrit depuis :</strong> <?= htmlspecialchars($profil['date_inscription']) ?></li>
            </ul>

            <div class="form-buttons">
                <a href="/profil/modifProfil" class="form-submit">Modifier mes informations</a>

            </div>
        </div>
    </div>
</div>
