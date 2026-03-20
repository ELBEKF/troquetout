<main class="container py-5">
    <div class="form-card card glass-effect mx-auto shadow-lg card-wrap card-wrap--xl">
        
        <header class="card-header bg-transparent border-0 pt-4 px-4 text-center">
            <div class="icon-badge-circle mb-3 mx-auto bg-warning-subtle text-warning" aria-hidden="true">
                <i class="bi bi-pencil-square h3 mb-0"></i>
            </div>
            <h1 class="h2 fw-bold mb-0">Modifier votre demande</h1>
            <p class="text-muted mt-2">Mettez à jour les détails de votre besoin pour la communauté.</p>
        </header>

        <div class="card-body p-4 p-lg-5">
            <form method="POST" class="modern-form">
                
                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Détails de l'annonce</legend>
                    
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="titre">
                            Titre <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <input class="form-control form-control-lg" type="text" id="titre" name="titre" 
                               value="<?= htmlspecialchars($request['titre']) ?>" required aria-required="true">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="description">
                            Description détaillée <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <textarea class="form-control" id="description" name="description" rows="5" 
                                  required aria-required="true"><?= htmlspecialchars($request['description']) ?></textarea>
                    </div>
                </fieldset>

                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Paramètres de l'échange</legend>
                    
                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="type_demande">Type de demande <span class="text-danger" aria-hidden="true">*</span></label>
                            <select class="form-select" id="type_demande" name="type_demande" required>
                                <option value="échange" <?= $request['type_demande'] === 'échange' ? 'selected' : '' ?>>Échange</option>
                                <option value="don"     <?= $request['type_demande'] === 'don'     ? 'selected' : '' ?>>Don</option>
                                <option value="pret"    <?= $request['type_demande'] === 'pret'    ? 'selected' : '' ?>>Prêt</option>
                                <option value="location"<?= $request['type_demande'] === 'location'? 'selected' : '' ?>>Location</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="date_besoin">Date de besoin <span class="text-danger" aria-hidden="true">*</span></label>
                            <input class="form-input form-control" type="date" name="date_besoin" id="date_besoin" 
                                   value="<?= htmlspecialchars($request['date_besoin']) ?>" required>
                        </div>
                    </div>
                </fieldset>

                <div class="d-flex flex-column flex-md-row gap-3 mt-5 pt-3 border-top">
                    <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold flex-grow-1">
                        <i class="bi bi-check2-circle me-2"></i>Enregistrer les modifications
                    </button>
                    <a href="/mesdemandes" class="btn btn-outline-secondary btn-lg px-4">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>