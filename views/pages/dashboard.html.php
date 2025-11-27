<link rel="stylesheet" href="/css/dashboard.css">

<?php if (isset($_SESSION['success'])) : ?>
    <div class="alert alert-success" id="successMessage">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
    <script>
        setTimeout(() => {
            const msg = document.getElementById('successMessage');
            if (msg) {
                msg.style.transition = 'opacity 0.4s ease-out';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 400);
            }
        }, 1500);
    </script>
<?php endif; ?>

<div class="dashboard-wrapper">
    <!-- 🧭 Barre latérale -->
    <aside class="sidebar">
        <h2 class="sidebar-title">Admin</h2>
        <button class="sidebar-btn active" id="btnUsers">👤 Utilisateurs</button>
        <button class="sidebar-btn" id="btnOffers">🏠 Offres</button>
    </aside>

    <!-- 🧱 Contenu principal -->
    <div class="admin-dashboard">
        <h1 class="form-title">Dashboard Administrateur</h1>

        <!-- 📊 Statistiques -->
        <section class="stat">
            <h3>Statistiques</h3>
            <div class="stat-cards">
                <div class="stat-card">
                    <span class="stat-title">Utilisateurs enregistrés</span>
                    <p class="stat-number"><?= $stats['total_users'] ?></p>
                </div>
                <div class="stat-card">
                    <span class="stat-title">Offres publiées</span>
                    <p class="stat-number"><?= $stats['total_offers'] ?></p>
                </div>
            </div>
        </section>

        <!-- 👤 Liste des utilisateurs -->
        <section class="admin-section" id="usersSection">
            <h3>Liste des utilisateurs</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th><th>Nom</th><th>Email</th><th>Téléphone</th>
                            <th>Ville</th><th>Code postal</th><th>Rôle</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= $u['id'] ?></td>
                            <td><?= htmlspecialchars($u['nom']) . ' ' . htmlspecialchars($u['prenom']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars($u['telephone']) ?></td>
                            <td><?= htmlspecialchars($u['ville']) ?></td>
                            <td><?= htmlspecialchars($u['code_postal']) ?></td>
                            <td><span class="role <?= $u['role'] ?>"><?= ucfirst($u['role']) ?></span></td>
                            <td class="action-buttons">
                                <a href="/admin/modifUser/<?= $u['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="/deleteUser/<?= $u['id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 🏠 Liste des offres -->
        <section class="admin-section" id="offersSection" style="display:none;">
            <h3>Liste des offres</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th><th>ID</th><th>Titre</th><th>Type</th>
                            <th>Ville</th><th>Statut</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($offers as $o): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($o['photo']) ?>" alt="Photo" class="offer-thumbnail"></td>
                            <td><?= $o['id'] ?></td>
                            <td><?= htmlspecialchars($o['titre']) ?></td>
                            <td><?= htmlspecialchars($o['type']) ?></td>
                            <td><?= htmlspecialchars($o['localisation']) ?></td>
                            <td><?= $o['statut'] ? '<span class="status active">Actif</span>' : '<span class="status inactive">Inactif</span>' ?></td>
                            <td class="action-buttons">
                                <a href="/offers/detail/<?= urlencode($o['id']) ?>" class="btn btn-sm btn-outline-primary">Détail</a>
                                <a href="/offers/modifoffer/<?= $o['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="/deleteOffer/<?= $o['id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Supprimer cette offre ?');">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnUsers = document.getElementById('btnUsers');
    const btnOffers = document.getElementById('btnOffers');
    const usersSection = document.getElementById('usersSection');
    const offersSection = document.getElementById('offersSection');

    btnUsers.addEventListener('click', () => {
        usersSection.style.display = 'block';
        offersSection.style.display = 'none';
        btnUsers.classList.add('active');
        btnOffers.classList.remove('active');
    });

    btnOffers.addEventListener('click', () => {
        usersSection.style.display = 'none';
        offersSection.style.display = 'block';
        btnOffers.classList.add('active');
        btnUsers.classList.remove('active');
    });
});
</script>
