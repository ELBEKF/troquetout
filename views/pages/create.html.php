
<main class="container py-5">
    <div class="form-card card glass-effect mx-auto shadow-lg card-wrap card-wrap--800 card-wrap--r-xl">
        
        <header class="card-header bg-transparent border-0 pt-4 px-4 text-center">
            <div class="icon-badge-circle mb-3 mx-auto bg-secondary-subtle text-secondary">
                <i class="bi bi-search h3 mb-0" aria-hidden="true"></i>
            </div>
            <h1 class="h2 fw-bold mb-0">Publier une demande</h1>
            <p class="text-muted mt-2">Vous ne trouvez pas votre bonheur ? Demandez à la communauté.</p>
        </header>

        <div class="card-body p-4 p-lg-5">
            <form action="create" method="POST" class="modern-form">
                
                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Votre besoin</legend>
                    
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="titre">
                            Titre de votre recherche <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <input class="form-control form-control-lg" type="text" id="titre" name="titre" 
                               required placeholder="Ex: Recherche vélo de ville pour le week-end" 
                               aria-required="true">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="description">
                            Description précise <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <textarea class="form-control" id="description" name="description" rows="4" 
                                  required placeholder="Détaillez ce que vous recherchez, pour quelle durée..." 
                                  aria-required="true"></textarea>
                    </div>
                </fieldset>

                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Détails techniques</legend>
                    
                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="type_demande">Type de transaction <span class="text-danger" aria-hidden="true">*</span></label>
                            <select class="form-select" id="type_demande" name="type_demande" required>
                                <option value="" disabled selected>-- Choisir --</option>
                                <option value="pret">Prêt</option>
                                <option value="don">Don</option>
                                <option value="location">Location</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="localisation">Où cherchez-vous ? <span class="text-danger" aria-hidden="true">*</span></label>
                            <input class="form-control" type="text" id="localisation" name="localisation" 
                                   placeholder="Ville ou Code Postal" required>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label fw-semibold" for="photo">Illustration (URL de l'image)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-link-45deg" aria-hidden="true"></i></span>
                            <input class="form-control" type="url" id="photo" name="photo" 
                                   placeholder="https://exemple.com/image.jpg">
                        </div>
                        <div class="form-text">Optionnel : un lien vers une image montrant ce que vous cherchez.</div>
                    </div>
                </fieldset>
<div class="col-md-6 form-group mt-3">
    <label class="form-label fw-semibold" for="date_besoin">
        Date de besoin <span class="text-danger" aria-hidden="true">*</span>
    </label>
    <input class="form-control" type="date" id="date_besoin" name="date_besoin" 
           required min="<?= date('Y-m-d') ?>">
    <div class="form-text">Quand avez-vous besoin de cet objet ?</div>
</div>
                <div class="d-flex flex-column flex-md-row gap-3 mt-5 pt-3 border-top">
                    <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold flex-grow-1">
                        Envoyer ma demande
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-action="back">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>