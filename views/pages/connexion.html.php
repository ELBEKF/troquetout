<!--  -->

<?php if (!empty($error)): ?>
    <div id="errorModal" class="connexion-modal">
        <div class="connexion-modal-content">
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    </div>
<?php endif; ?>
<h1 class="form-title">Connexion</h1>
<div class="connexion-center">
<form action="/connexion" method="POST" class="connexion-form">
        <body class="connexion-body">
        <div>
            <label for="inputEmail" class="connexion-label">Email</label>
            <input type="email" name="inputEmail" id="inputEmail" class="connexion-input">
        </div>
        <div>
            <label for="inputMdp" class="connexion-label">Mot de passe</label>
            <input type="password" name="inputMdp" id="inputMdp" class="connexion-input">
        </div>
        <div>
            <input type="checkbox" id="rememberMe" class="connexion-checkbox">
            <label for="rememberMe" class="connexion-checkbox-label">
                Se souvenir de moi !
            </label>
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
