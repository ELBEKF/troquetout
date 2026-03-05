<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TroqueTout — Plateforme de partage, d'échange et de don d'objets entre particuliers.">
    <title><?= htmlspecialchars($title) ?></title>

    <link rel="icon" type="image/png" href="/images/sac.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/style.css">

    <meta property="og:title" content="<?= htmlspecialchars($title) ?>">
    <meta property="og:type" content="website">

    <script>
        (function () {
            var KEY = 'troquetout-theme';
            function getTheme() {
                var saved = localStorage.getItem(KEY);
                if (saved === 'dark' || saved === 'light') return saved;
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            function applyTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem(KEY, theme);
            }
            window.toggleTheme = function () {
                var current = document.documentElement.getAttribute('data-theme') || getTheme();
                applyTheme(current === 'dark' ? 'light' : 'dark');
            };
            applyTheme(getTheme());
        })();
    </script>
</head>
<body>
    <div class="carte" aria-hidden="true">
        <div class="gradient-orb"></div>
        <div class="floating-cards">
            <div class="cart cart-1" role="presentation">⚽️</div>
            <div class="cart cart-2" role="presentation">🏀</div>
            <div class="cart cart-3" role="presentation">🎾</div>
            <div class="cart cart-4" role="presentation">🥊</div>
            <div class="cart cart-5" role="presentation">🏊‍♂️</div>
        </div>
    </div>

    <a href="#main-content" class="skip-link">Aller au contenu principal</a>

    <?php
    if (!empty($_SESSION['user_id'])) {
        require_once 'views/partials/header.php';
    } else {
        require_once 'views/partials/headerdeco.php';
    }
    ?>

    <main id="main-content">
        <div class="container">
            <?= $content ?>
        </div>
    </main>

    <?php require_once 'views/partials/footer.php'; ?>

    <div id="scrollUp">
        <a href="#main-content" aria-label="Retourner en haut de la page">
            <img class="scrollUp-img" src="/images/arrow-up.png" alt="">
        </a>
    </div>

    <script src="/plugins/jquery/jquery.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="/plugins/slick-carousel/slick/slick.min.js" defer></script>
    <script src="/plugins/jquery-nice-select/js/jquery.nice-select.min.js" defer></script>
    <script src="/js/scripts.js" defer></script>

    <?php if (isset($pageJS)): ?>
        <?php foreach ((array)$pageJS as $js): ?>
            <script src="<?= htmlspecialchars($js) ?>" defer></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>