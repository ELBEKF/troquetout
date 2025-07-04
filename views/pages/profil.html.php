<h1 class="text-2xl font-bold mb-4"><?= htmlspecialchars($title) ?></h1>

<div class="profil-info bg-white shadow-md rounded-xl p-6 max-w-md mx-auto">
    <ul class="space-y-2">
        <li><strong>Nom :</strong> <?= htmlspecialchars($profil['nom']) ?></li>
        <li><strong>Prénom :</strong> <?= htmlspecialchars($profil['prenom']) ?></li>
        <li><strong>Email :</strong> <?= htmlspecialchars($profil['email']) ?></li>
        <li><strong>Téléphone :</strong> <?= htmlspecialchars($profil['telephone']) ?></li>
        <li><strong>Ville :</strong> <?= htmlspecialchars($profil['ville']) ?></li>
        <li><strong>Code postal :</strong> <?= htmlspecialchars($profil['code_postal']) ?></li>
        <li><strong>Inscrit depuis :</strong> <?= htmlspecialchars($profil['date_inscription']) ?></li>
    </ul>

    <div class="mt-6">
        <a href="/modifProfil.php" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Modifier mes informations</a>
    </div>
</div>
