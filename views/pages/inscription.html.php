

<main class="container py-5">
    <div class="card glass-effect mx-auto shadow-lg card-wrap card-wrap--lg">
        
        <header class="card-header bg-transparent border-0 pt-4 px-4 text-center">
            <h1 class="h2 fw-bold mb-0">Créer un compte</h1>
            <p class="text-muted mt-2">Rejoignez la communauté TroqueTout et commencez à échanger.</p>
        </header>

        <div class="card-body p-4 p-lg-5">
            <form action="/inscription" method="POST" class="modern-form">
                
                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Identité</legend>
                    
                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="nom">Nom <span class="text-danger" aria-hidden="true">*</span></label>
                            <input class="form-control" type="text" name="nom" id="nom" required aria-required="true">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="prenom">Prénom <span class="text-danger" aria-hidden="true">*</span></label>
                            <input class="form-control" type="text" name="prenom" id="prenom" required aria-required="true">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Connexion & Sécurité</legend>
                    
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="email">Adresse Email <span class="text-danger" aria-hidden="true">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input class="form-control" type="email" name="email" id="email" 
                                   placeholder="nom@exemple.com" required aria-required="true">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="password">Mot de passe <span class="text-danger" aria-hidden="true">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input class="form-control" type="password" name="password" id="password" 
                                   required aria-required="true" minlength="8">
                        </div>
                        <div class="form-text">8 caractères minimum recommandés.</div>
                    </div>
                </fieldset>

                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Coordonnées (Optionnel)</legend>
                    
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="telephone">Téléphone</label>
                        <input class="form-control" type="tel" name="telephone" id="telephone" placeholder="06 00 00 00 00">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-8 form-group">
                            <label class="form-label fw-semibold" for="ville">Ville</label>
                            <input class="form-control" type="text" name="ville" id="ville" placeholder="Ex: Lyon">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label fw-semibold" for="code_postal">Code postal</label>
                            <input class="form-control" type="text" name="code_postal" id="code_postal" placeholder="69000">
                        </div>
                    </div>
                </fieldset>

                <div class="mt-5">
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                        Finaliser mon inscription
                    </button>
                    <p class="text-center mt-3 mb-0 small text-muted">
                        En vous inscrivant, vous acceptez nos <a href="/contact">Conditions d'Utilisation</a>.
                    </p>
                </div>

            </form>
        </div>
    </div>
</main>