<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TroqueTout — Plateforme moderne de partage et d'échange d'objets entre particuliers.">
    <title><?= htmlspecialchars($title) ?> | TroqueTout</title>

    <link rel="icon" type="image/png" href="/images/sac.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/style.scss.css">

</head>
<body class="app-container">

    <?php if (!empty($_SESSION['user_id'])): ?>
        <?php require_once 'views/partials/header.php'; ?>
    <?php else: ?>
        <?php require_once 'views/partials/headerdeco.php'; ?>
    <?php endif; ?>

    <!-- Messages flash -->
    <div class="container mt-3 flash-messages" aria-live="polite">
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i>
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i>
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        <?php endif; ?>
    </div>
    <div class="main-layout py-4">
        <div class="container">
            <?= $content ?>
        </div>
    </div>

    <?php require_once 'views/partials/footer.php'; ?>
    <button id="scrollUp"
            class="hidden"
            aria-label="Retourner en haut de la page">
        <i class="bi bi-arrow-up" aria-hidden="true"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="/js/scripts.js" defer></script>

</body>
</html>