<!--  -->
<link rel="stylesheet" href="/css/connexion.css">

<?php if (!empty($error)): ?>
    <div id="errorModal" class="connexion-modal">
        <div class="connexion-modal-content">
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    </div>
<?php endif; ?>
<div class="connexion-center">
    <form action="/connexion" method="POST" class="connexion-form">
    <h1 class="form-title">Connexion&nbsp;<img class="logoco" src="/images/sac.png" alt="TroqueTout" /></h1>
        <body class="connexion-body">
        <div>
            <label for="inputEmail" class="connexion-label">Email</label>
            <input placeholder="exemple@gmail.com" type="email" name="inputEmail" id="inputEmail" class="connexion-input">
        </div>
        <div>
            <label for="inputMdp" class="connexion-label">Mot de passe</label>
            <input placeholder="********" type="password" name="inputMdp" id="inputMdp" class="connexion-input">
        </div>
        <div>
            <button type="submit" class="connexion-button">Se connecter</button>
        </div>
        <div class="connexion-footer">
            <p>Vous n'avez pas de compte ? <a href="/inscription">Inscription !</a></p>
        </div>
    </form>
</div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            var $modal = $('#errorModal');
            if ($modal.length) {
                setTimeout(function() {
                    $modal.fadeOut(400);
                }, 1500); // affiché 1,5 secondes
            }
        });
    </script>
</body>
