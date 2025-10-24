<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" type="image/png" href="/images/sac.png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- CSS de base -->
    <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/headerdeco.css">

    
    <!-- CSS spécifiques aux pages -->
    <?php if (isset($pageCSS)): ?>
        <?php foreach ((array)$pageCSS as $css): ?>
            <link rel="stylesheet" href="<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>

<!-- Fond animé -->
<div class="carte">
    <div class="gradient-orb"></div>
    <div class="floating-cards">
        <div class="cart cart-1">⚽️</div>
        <div class="cart cart-2">🏀</div>
        <div class="cart cart-3">🎾</div>
        <div class="cart cart-4">🥊</div>
        <div class="cart cart-5">🏊‍♂️</div>
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

<!-- Scripts -->
<script src="/plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/plugins/slick-carousel/slick/slick.min.js"></script>
<script src="/plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="/js/script.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>

 
<!-- Scripts spécifiques aux pages -->
<?php if (isset($pageJS)): ?>
    <?php foreach ((array)$pageJS as $js): ?>
        <script src="<?= $js ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<!-- <div id="scrollUp">
<a href="#top">TOP</a>
</div> -->

<div id="scrollUp">
    <a href="/"><img class="scrollUp" src="/images/arrow-up.png" alt="scrolltop" /></a>
    </div>


<style>
  #scrollUp
{

position: fixed;
padding: 150px;
width: 10px;
bottom : 10px;
right: 20px;  
z-index: 9999;  
}

#scrollUp img.scrollUp {
  width: 50px;   /* 🔹 plus petit qu’avant (40 → 30px) */
  height: 50px;
  opacity: 0.7;
  transition: opacity 0.3s, transform 0.3s;
  cursor: pointer;
}
#scrollUp img.scrollUp:hover {
  opacity: 1;
  transform: scale(1.1);
}
html {
  scroll-behavior: smooth;
  overflow-y: scroll; /* (pour éviter le décalage dont on parlait avant) */
}
</style>
</body>
</html>


<script>
  // attend que la page soit chargée avant d’ajouter l’événement
  document.querySelector('#scrollUp a').addEventListener('click', function(e) {
    e.preventDefault(); // empêche le rechargement
    window.scrollTo({
      top: 0,
      behavior: 'smooth' // effet fluide
    });
  });
    
    jQuery(function(){
  $(function () {
    $(window).scroll(function () { //Fonction appelée quand on descend la page
      if ($(this).scrollTop() > 200 ) {  // Quand on est à 200pixels du haut de page,
        $('#scrollUp').css('right','10px'); // Replace à 10pixels de la droite l'image
        // console.log("sdlk,dlms")
    } else { 
        $('#scrollUp').removeAttr( 'style' ); // Enlève les attributs CSS affectés par javascript
        // console.log("sdlk,dlms")
    }
});
});
});

console.log("sdlk,dlms")
 
</script>
