<?php
/**
 * Vue : Connexion
 * Blindée pour le passage de titre (Sémantique & Accessibilité)
 */
?>

<main class="container d-flex align-items-center justify-content-center min-h-70vh">
    <div class="card glass-effect p-4 shadow-lg card-wrap card-wrap--xs card-wrap--r-lg">
        
        <header class="text-center mb-4">
            <img src="/images/sac.png" alt="Logo TroqueTout" class="mb-3 logo-auth">
            <h1 class="h3 fw-bold">Bon retour parmi nous</h1>
            <p class="text-muted">Connectez-vous pour gérer vos échanges</p>
        </header>

        <form action="/connexion" method="POST">
            
            <div class="mb-3">
                <label for="inputEmail" class="form-label fw-semibold">Adresse Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="bi bi-envelope text-muted" aria-hidden="true"></i>
                    </span>
                    <input type="email" 
                           name="inputEmail" 
                           id="inputEmail" 
                           class="form-control border-start-0" 
                           placeholder="exemple@gmail.com" 
                           required 
                           autofocus>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between">
                    <label for="inputMdp" class="form-label fw-semibold">Mot de passe</label>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="bi bi-lock text-muted" aria-hidden="true"></i>
                    </span>
                    <input type="password" 
                           name="inputMdp" 
                           id="inputMdp" 
                           class="form-control border-start-0" 
                           placeholder="********" 
                           required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-3">
                Se connecter
            </button>

            <div class="text-center mt-3">
                <p class="mb-0 text-muted">
                    Pas encore de compte ? 
                    <a href="/inscription" class="text-primary fw-bold text-decoration-none">Inscrivez-vous ici</a>
                </p>
            </div>

        </form>
    </div>
</main>