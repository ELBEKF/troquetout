
<main class="container py-5">
    <div class="card glass-effect mx-auto shadow-lg card-wrap card-wrap--md border-0">
        
        <header class="card-header bg-transparent border-0 pt-5 px-4 text-center">
            <div class="profile-avatar-wrapper mb-4 position-relative d-inline-block">
                <div class="avatar-circle avatar-circle--2xl avatar-gradient avatar-circle--bordered-white shadow-lg">
                    <?= strtoupper(substr($user['nom'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm border avatar-edit-badge">
                    <i class="bi bi-pencil-fill text-primary" aria-hidden="true"></i>
                </div>
            </div>
            
            <h1 class="h2 fw-bold mb-0">Modifier mon profil</h1>
            <p class="text-muted mt-2">Mettez à jour vos informations pour la communauté TroqueTout.</p>
        </header>

        <div class="card-body p-4 p-lg-5">
            <form class="modern-form" method="POST" action="/profil/modifProfil">
                
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id'] ?? '') ?>">

                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">
                        <i class="bi bi-person-badge me-2" aria-hidden="true"></i>Identité
                    </legend>
                    
                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="nom">Nom <span class="text-danger">*</span></label>
                            <input class="form-control shadow-sm" type="text" name="nom" id="nom" 
                                   value="<?= htmlspecialchars($user['nom'] ?? '') ?>" required aria-required="true">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="prenom">Prénom <span class="text-danger">*</span></label>
                            <input class="form-control shadow-sm" type="text" name="prenom" id="prenom" 
                                   value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" required aria-required="true">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">
                        <i class="bi bi-envelope-at me-2" aria-hidden="true"></i>Contact
                    </legend>
                    
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="email">Adresse Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted" aria-hidden="true"></i></span>
                            <input class="form-control border-start-0 shadow-sm" type="email" name="email" id="email" 
                                   value="<?= htmlspecialchars($user['email'] ?? '') ?>" required aria-required="true">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="telephone">Téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone text-muted" aria-hidden="true"></i></span>
                            <input class="form-control border-start-0 shadow-sm" type="tel" name="telephone" id="telephone" 
                                   value="<?= htmlspecialchars($user['telephone'] ?? '') ?>" placeholder="06 00 00 00 00">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">
                        <i class="bi bi-geo-alt me-2" aria-hidden="true"></i>Localisation
                    </legend>
                    
                    <div class="row g-3">
                        <div class="col-md-8 form-group">
                            <label class="form-label fw-semibold" for="ville">Ville</label>
                            <input class="form-control shadow-sm" type="text" name="ville" id="ville" 
                                   value="<?= htmlspecialchars($user['ville'] ?? '') ?>" placeholder="Ex: Argenteuil">
                        </div>

                        <div class="col-md-4 form-group">
                            <label class="form-label fw-semibold" for="code_postal">Code postal</label>
                            <input class="form-control shadow-sm" type="text" name="code_postal" id="code_postal" 
                                   value="<?= htmlspecialchars($user['code_postal'] ?? '') ?>" placeholder="95100">
                        </div>
                    </div>
                </fieldset>

                <div class="d-flex flex-column flex-md-row gap-3 mt-5 pt-3 border-top">
                    <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold flex-grow-1 shadow-sm">
                        <i class="bi bi-check-circle me-2" aria-hidden="true"></i>Enregistrer les modifications
                    </button>
                    <a href="/profil" class="btn btn-outline-secondary btn-lg px-4">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>