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
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/plugins/jquery-nice-select/css/nice-select.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>

<!-- Fond animé -->
<div class="carte">
    <div class="gradient-orb"></div>
    <div class="floating-cards">
        <div class="cart cart-1">⚽️</div>
        <div class="cart cart-2">🏀</div>
        <div class="cart cart-2">🎾</div>
        <div class="cart cart-3">🥊</div>
        <div class="cart cart-3">🏊‍♂️</div>
    </div>
</div>

<?php
if (!empty($_SESSION['user_id'])) {
    require_once 'views/partials/header.php';
} else {
    require_once 'views/partials/headerdeco.php';
}
?>

<?= $content ?>

<?php require_once 'views/partials/footer.php'; ?>

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/plugins/slick-carousel/slick/slick.min.js"></script>
<script src="/plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="/js/script.js"></script>
</body>
</html>
