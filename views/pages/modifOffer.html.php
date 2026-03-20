<?php

if (isset($modif) && !isset($offer)) {
    $offer = $modif;
}
?>

<main class="container py-5">
    <div class="form-card card glass-effect mx-auto shadow-lg card-wrap card-wrap--2xl">
        
        <header class="card-header bg-transparent border-0 pt-4 px-4 text-center">
            <div class="avatar-circle avatar-circle--lg avatar-gradient avatar-circle--bordered mb-3 mx-auto shadow" aria-hidden="true">
                <?= isset($_SESSION['user_nom']) ? strtoupper(substr($_SESSION['user_nom'], 0, 1)) : 'E' ?>
            </div>
            <h1 class="h2 fw-bold mb-0">Modifier votre offre</h1>
            <p class="text-muted mt-2">Mettez à jour les détails de votre annonce #<?= htmlspecialchars($offer['id'] ?? '') ?></p>
        </header>

        <div class="card-body p-4 p-lg-5">
            <form action="/offers/updateoffer" method="POST" class="modern-form" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?= htmlspecialchars($offer['id'] ?? '') ?>">

                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Contenu de l'annonce</legend>
                    
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="titre">Titre de l'objet <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="titre" id="titre" 
                               value="<?= htmlspecialchars($offer['titre'] ?? '') ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="description">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" id="description" rows="5" required><?= htmlspecialchars($offer['description'] ?? '') ?></textarea>
                    </div>
                </fieldset>

                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Catégorie et État</legend>
                    
                    <div class="row g-3">
                        <div class="col-md-4 form-group">
                            <label class="form-label fw-semibold" for="sens">Sens</label>
                            <select class="form-select" name="sens" id="sens" required>
                                <option value="offre"   <?= ($offer['sens'] ?? '') === 'offre'   ? 'selected' : '' ?>>Offre</option>
                                <option value="demande" <?= ($offer['sens'] ?? '') === 'demande' ? 'selected' : '' ?>>Demande</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label fw-semibold" for="type">Type d'échange</label>
                            <select class="form-select" name="type" id="type" required>
                                <option value="don"      <?= ($offer['type'] ?? '') === 'don'      ? 'selected' : '' ?>>Don</option>
                                <option value="pret"     <?= ($offer['type'] ?? '') === 'pret'     ? 'selected' : '' ?>>Prêt</option>
                                <option value="location" <?= ($offer['type'] ?? '') === 'location' ? 'selected' : '' ?>>Location</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label fw-semibold" for="etat">État de l'objet</label>
                            <select class="form-select" name="etat" id="etat" required>
                                <option value="neuf" <?= ($offer['etat'] ?? '') === 'neuf' ? 'selected' : '' ?>>Neuf</option>
                                <option value="bon"  <?= ($offer['etat'] ?? '') === 'bon'  ? 'selected' : '' ?>>Bon</option>
                                <option value="use"  <?= ($offer['etat'] ?? '') === 'use'  ? 'selected' : '' ?>>Utilisé</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Modalités et Lieu</legend>
                    
                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="prix">Prix (€)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-currency-euro" aria-hidden="true"></i></span>
                                <input class="form-control" type="number" step="0.01" name="prix" id="prix" value="<?= htmlspecialchars($offer['prix'] ?? '0') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="caution">Caution (€)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-lock" aria-hidden="true"></i></span>
                                <input class="form-control" type="number" step="0.01" name="caution" id="caution" value="<?= htmlspecialchars($offer['caution'] ?? '0') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label fw-semibold" for="localisation">Localisation</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt" aria-hidden="true"></i></span>
                            <input class="form-control" type="text" name="localisation" id="localisation" value="<?= htmlspecialchars($offer['localisation'] ?? '') ?>" required>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mb-5 border-0 p-0">
                    <legend class="h5 mb-3 fw-bold border-bottom pb-2 text-primary">Visuel et Statut</legend>
                    
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="photo">Changer la photo</label>
                        <input class="form-control" type="file" name="photo" id="photo" accept="image/*">
                        <?php if (!empty($offer['photo'])): ?>
                            <div class="mt-3 p-2 border rounded bg-light d-inline-block">
                                <span class="d-block small text-muted mb-1">Photo actuelle :</span>
                                <img src="<?= htmlspecialchars($offer['photo']) ?>" alt="Aperçu de la photo actuelle" class="img-thumb-sm">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="disponibilite">Disponible dès le</label>
                            <input class="form-control" type="date" name="disponibilite" id="disponibilite" value="<?= htmlspecialchars($offer['disponibilite'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="statut">Visibilité</label>
                            <select class="form-select" name="statut" id="statut" required>
                                <option value="1" <?= ($offer['statut'] ?? 0) == 1 ? 'selected' : '' ?>>✅ Actif (Publiée)</option>
                                <option value="0" <?= ($offer['statut'] ?? 0) == 0 ? 'selected' : '' ?>>⛔ Inactif (Masquée)</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <div class="d-flex flex-column flex-md-row gap-3 mt-4 pt-4 border-top">
                    <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold flex-grow-1 shadow-sm">
                        <i class="bi bi-save me-2" aria-hidden="true"></i>Enregistrer les modifications
                    </button>
                    <a href="/mesoffres" class="btn btn-outline-secondary btn-lg px-4">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>