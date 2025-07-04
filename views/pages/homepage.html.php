<?php
session_start();
?>

<div class="container my-5">
    <h1 class="mb-4">TOUTES LES OFFRES</h1>


    <form method="GET" class="mb-4 d-flex flex-wrap gap-3 align-items-end">
    <div class="form-group">
        <label for="search">Titre</label>
        <input type="text" name="search" id="search" placeholder="Rechercher par nom" value="<?= htmlspecialchars($search ?? '') ?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="type">Type d'offre</label>
        <select name="type" id="type" class="form-select">
            <option value="">-- Tous les types --</option>
            <option value="don" <?= ($type === 'don') ? 'selected' : '' ?>>Don</option>
            <option value="location" <?= ($type === 'location') ? 'selected' : '' ?>>Location</option>
            <option value="pret" <?= ($type === 'pret') ? 'selected' : '' ?>>Prêt</option>
        </select>
    </div>
<div class="form-group">
    <label for="etat">État</label>
    <select name="etat" id="etat" class="form-select">
        <option value="">-- Tous les états --</option>
        <option value="neuf" <?= ($etat === 'neuf') ? 'selected' : '' ?>>Neuf</option>
        <option value="bon" <?= ($etat === 'bon') ? 'selected' : '' ?>>Bon</option>
        <option value="usé" <?= ($etat === 'usé') ? 'selected' : '' ?>>Usé</option>
    </select>
</div>

<div class="form-group">
    <label for="localisation">Localisation</label>
    <input type="text" name="localisation" id="localisation" placeholder="Ville" value="<?= htmlspecialchars($localisation ?? '') ?>" class="form-control">
</div>
<div class="form-group">
    <label for="sort">Trier par date</label>
    <select name="sort" id="sort" class="form-select">
        <option value="desc" <?= ($sort === 'desc') ? 'selected' : '' ?>>Plus récentes</option>
        <option value="asc" <?= ($sort === 'asc') ? 'selected' : '' ?>>Plus anciennes</option>
    </select>
</div>

    <button type="submit" class="btn btn-primary">
        🔍 Rechercher
    </button>
</form>






    <a href="/addOffer.php" class="btn btn-primary mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
        </svg>
        Ajouter une offre
    </a>

    <div class="row">
        <?php foreach ($offers as $offer): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($offer['photo']) ?>" class="card-img-top" alt="Photoooooo" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
    <h5 class="card-title"><?= htmlspecialchars($offer['titre']) ?></h5>
    <p class="card-text mb-1"><strong>Type:</strong> <?= htmlspecialchars($offer['type']) ?></p>
    <p class="card-text mb-1"><strong>Prix:</strong> <?= number_format($offer['prix'], 2) ?> €</p>      
    <p class="card-text mb-1"><strong>Ville:</strong> <?= htmlspecialchars($offer['localisation']) ?></p>
    <p class="card-text mb-2"><strong>Disponibilité:</strong> <?= htmlspecialchars($offer['disponibilite']) ?></p>
    <p class="card-text">
        <strong>Statut:</strong> <?= $offer['statut'] ? '✅ Actif' : '⛔ Inactif' ?>
    </p>

    <a href="/offerdetail.php?id=<?= urlencode($offer['id']) ?>" class="btn btn-outline-primary mt-2">Détail</a>
    <?php if (
    isset($_SESSION['user_id']) && 
    ($_SESSION['user_id'] == $offer['user_id'] || ($_SESSION['user_role'] ?? '') === 'admin')
): ?>
    <a href="/deleteOffer.php?id=<?= urlencode($offer['id']) ?>" 
       class="btn btn-outline-danger mt-2"
       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?');">
       Supprimer
    </a>
    <a href="modifOffer.php?id=<?= $offer['id'] ?>" class="btn btn-warning mt-2">Modifier</a>
<?php endif; ?>

    <form action="/addfavoris.php" method="POST" class="mt-2">
        <input type="hidden" name="offer_id" value="<?= $offer['id'] ?>">
        <button type="submit" class="btn btn-outline-secondary w-100">
            ❤️ Ajouter aux favoris
        </button>
    </form>
</div>


                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
