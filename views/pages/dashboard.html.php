

<div class="container my-5">
    <h1>Dashboard Admin</h1>

    <section>
        <h3>Statistiques</h3>
        <ul>
            <li>Utilisateurs enregistrés : <?= $stats['total_users'] ?></li>
            <li>Offres publiées : <?= $stats['total_offers'] ?></li>
        </ul>
    </section>

    <hr>

    <section>
        <h3>Liste des utilisateurs</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th><th>Nom</th><th>Email</th><th>Telephone</th><th>Ville</th><th>code postale</th><th>Rôle</th><th>Actions</th>
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
                    <td><?= $u['role'] ?></td>
                    <td>
                        <?php if ($_SESSION['user_role'] == 'admin'): ?>
                        <a href="/offerdetail.php?id=<?= urlencode($offer['id']) ?>" class="btn btn-outline-primary mt-2">Détail</a>

                        <a href="/deleteUser.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                           <a href="/modifUser.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-warning mt-2">Modifier</a>

                        

                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>

    <hr>

    <section>
    <h3>Liste des offres</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Image</th><th>ID</th><th>Titre</th><th>Type</th><th>Ville</th><th>Statut</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($offers as $o): ?>
            <tr>
                <td>
                    <img src="<?= htmlspecialchars($o['photo']) ?>" alt="Photo de l'offre"
                         style="height: 100px; width: 150px; object-fit: cover; border-radius: 8px;">
                </td>
                <td><?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['titre']) ?></td>
                <td><?= $o['type'] ?></td>
                <td><?= $o['localisation'] ?></td>
                <td><?= $o['statut'] ? '✅' : '⛔' ?></td>
                <td>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <a href="/deleteOffer.php?id=<?= $o['id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Supprimer cette offre ?');">Supprimer</a>
                       <a href="modifOffer.php?id=<?= $o['id'] ?>" class="btn btn-warning mt-2">Modifier</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>

</div>
