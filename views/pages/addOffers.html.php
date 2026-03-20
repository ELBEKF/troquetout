<main class="container py-5">
    <div class="form-card card glass-effect mx-auto shadow-lg card-wrap card-wrap--2xl card-wrap--r-lg">
        
        <header class="card-header bg-transparent border-0 pt-4 px-4 text-center">
            <h1 class="h2 fw-bold mb-0">Créer une nouvelle offre</h1>
            <p class="text-muted mt-2">Partagez vos objets avec la communauté TroqueTout.</p>
        </header>

        <div class="card-body p-4 p-lg-5">

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form class="modern-form" action="/offers/addOffer" method="POST" enctype="multipart/form-data">
                
                <section class="mb-4">
                    <h2 class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Informations générales</h2>
                    
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold" for="titre">Titre de l'annonce <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="titre" id="titre" 
                               placeholder="Ex: Vélo de course, Perceuse..." required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-bold" for="description">Description détaillée <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" id="description" rows="4" 
                                  placeholder="Décrivez l'état de l'objet, ses fonctionnalités..." required></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-bold" for="sens">Vous proposez ou demandez ?</label>
                            <select class="form-select" name="sens" id="sens">
                                <option value="offre" selected>Je propose un objet</option>
                                <option value="demande">Je recherche un objet</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-bold" for="type">Type d'échange</label>
                            <select class="form-select" name="type" id="type">
                                <option value="don">Don (Gratuit)</option>
                                <option value="pret">Prêt</option>
                                <option value="location">Location / Échange</option>
                            </select>
                        </div>
                    </div>
                </section>

                <section class="mb-4">
                    <h2 class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Détails de l'objet</h2>
                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-bold" for="categorie">Catégorie <span class="text-danger">*</span></label>
                            <select class="form-select" name="categorie" id="categorie" required>
                                <option value="Bricolage">Bricolage</option>
                                <option value="Jardinage">Jardinage</option>
                                <option value="Électronique">Électronique</option>
                                <option value="Loisirs">Loisirs</option>
                                <option value="Sport">Sport</option>
                                <option value="Divers" selected>Divers</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-bold" for="etat">État de l'objet <span class="text-danger">*</span></label>
                            <select class="form-select" name="etat" id="etat" required>
                                <option value="neuf">Neuf / Emballé</option>
                                <option value="bon" selected>Bon état</option>
                                <option value="use">Usagé / Fonctionnel</option>
                            </select>
                        </div>
                    </div>
                </section>

                <section class="mb-4">
                    <h2 class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Modalités et Lieu</h2>
                    <div class="row g-3">
                        <div class="col-md-4 form-group">
                            <label class="form-label fw-bold" for="prix">Prix (€)</label>
                            <input class="form-control" type="number" step="0.01" name="prix" id="prix" value="0" min="0">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label fw-bold" for="caution">Caution (€)</label>
                            <input class="form-control" type="number" step="0.01" name="caution" id="caution" value="0" min="0">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label fw-bold" for="statut">Visibilité</label>
                            <select class="form-select" name="statut" id="statut">
                                <option value="1" selected>Actif (Visible)</option>
                                <option value="0">Brouillon (Masqué)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-bold" for="localisation">Ville / Code Postal <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="localisation" id="localisation" 
                                   placeholder="Ex: Paris 75001" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-bold" for="disponibilite">Disponible dès le <span class="text-danger">*</span></label>
                            <input class="form-control" type="date" name="disponibilite" id="disponibilite" 
                                   value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                </section>

                <section class="mb-5">
                    <h2 class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Visuel</h2>
                    <div class="form-group">
                        <label class="form-label fw-bold" for="photo">Sélectionnez une image</label>
                        <input class="form-control" type="file" name="photo" id="photo" 
                               accept="image/png, image/jpeg, image/webp">
                        <div class="form-text mt-2 text-muted">Format accepté : JPG, PNG ou WebP. Max 2Mo. (Optionnel)</div>
                    </div>

                    <div id="preview-container" class="mt-3 d-none">
                        <img id="preview-img" src="#" alt="Prévisualisation"
                             class="rounded shadow-sm img-preview-upload">
                    </div>
                </section>

                <div class="d-grid gap-3 d-md-flex justify-content-md-end mt-4 pt-4 border-top">
                    <a href="/mesoffres" class="btn btn-outline-secondary px-5 py-2">Annuler</a>
                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm fw-bold">
                        <i class="bi bi-plus-circle me-2" aria-hidden="true"></i>Publier mon annonce
                    </button>
                </div>

            </form>
        </div>
    </div>
</main>