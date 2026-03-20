
<main class="container py-5">
    <div class="card glass-effect mx-auto shadow-lg card-wrap card-wrap--lg">
        
        <header class="card-header bg-transparent border-0 pt-5 px-4 text-center">
            <div class="avatar-circle avatar-circle--xl avatar-gradient avatar-circle--bordered mb-3 mx-auto shadow-sm">
                <?= strtoupper(substr($user['nom'] ?? 'U', 0, 1)) ?>
            </div>
            <h1 class="h3 fw-bold mb-1">Administration Utilisateur</h1>
            <p class="text-muted small">Modification du profil de : <strong><?= htmlspecialchars($user['email'] ?? '') ?></strong></p>
        </header>

        <div class="card-body p-4 p-lg-5">
            <div class="alert bg-primary-subtle border-0 mb-4 d-flex justify-content-around text-center small py-2 alert-stats">
                <div>
                    <span class="text-muted d-block">ID Système</span>
                    <span class="fw-bold">#<?= htmlspecialchars($user['id']) ?></span>
                </div>
                <div>
                    <span class="text-muted d-block">Rôle actuel</span>
                    <span class="badge bg-primary"><?= ucfirst(htmlspecialchars($user['role'] ?? 'user')) ?></span>
                </div>
                <div>
                    <span class="text-muted d-block">Membre depuis</span>
                    <span class="fw-bold"><?= htmlspecialchars($user['date_inscription'] ?? 'NC') ?></span>
                </div>
            </div>

            <form class="modern-form" method="POST" action="/admin/modifUser/<?= $user['id'] ?>">
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

                <fieldset class="mb-4 border-0 p-0">
                    <legend class="h6 fw-bold border-bottom pb-2 mb-3 text-primary text-uppercase legend-spaced">Identité & Contact</legend>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="nom">Nom</label>
                            <input class="form-control" type="text" name="nom" id="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label fw-semibold" for="prenom">Prénom</label>
                            <input class="form-control" type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold" for="email">Adresse Email</label>
                        <input class="form-control" type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label fw-semibold" for="telephone">N° de Téléphone</label>
                        <input class="form-control" type="tel" name="telephone" id="telephone" value="<?= htmlspecialchars($user['telephone'] ?? '') ?>">
                    </div>
                </fieldset>

                <fieldset class="mb-5 border-0 p-0">
                    <legend class="h6 fw-bold border-bottom pb-2 mb-3 text-primary text-uppercase legend-spaced">Localisation</legend>
                    <div class="row g-3">
                        <div class="col-md-8 form-group">
                            <label class="form-label fw-semibold" for="ville">Ville</label>
                            <input class="form-control" type="text" name="ville" id="ville" value="<?= htmlspecialchars($user['ville'] ?? '') ?>">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label fw-semibold" for="code_postal">Code Postal</label>
                            <input class="form-control" type="text" name="code_postal" id="code_postal" value="<?= htmlspecialchars($user['code_postal'] ?? '') ?>">
                        </div>
                    </div>
                </fieldset>

                <div class="d-flex flex-column flex-md-row gap-3 pt-4 border-top">
                    <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold flex-grow-1 shadow-sm">
                        <i class="bi bi-check-circle me-2" aria-hidden="true"></i>Appliquer les modifications
                    </button>
                    <a href="/admin" class="btn btn-outline-secondary btn-lg px-4">
                        Retour au dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>