<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion</title>
</head>

<body>

<header>
    <nav>
        <div>
            <h2>
                Bonjour, <?= htmlspecialchars($_SESSION['user_nom'] ?? 'invité') ?> !
            </h2>

            <ul>
                <li><a href="/offers.php">ACCUEIL</a></li>
                <li><a href="/demandes.php">LES DEMANDES</a></li>
                <li><a href="/mesoffres.php">MES ANNONCES</a></li>
                <li><a href="/mesdemande.php">MES DEMANDES</a></li>
                <li><a href="/mesfavoris.php">MES FAVORIES</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/messages_recus.php">MES MESSAGES</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <li><a href="/admin.php">DASHBOARD</a></li>
                <?php endif; ?>

                <li><a href="/profil.php">PROFIL</a></li>
                <li><a href="/contact.php">CONTACT</a></li>
                <li>
                    <form action="/deconnexion.php" method="post" style="display:inline;">
                        <button type="submit">SE DÉCONNECTER</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>

</body>
</html>
