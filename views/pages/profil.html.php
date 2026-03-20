<main class="container py-5">
    <div class="card glass-effect mx-auto shadow-lg card-wrap card-wrap--sm card-wrap--overflow">
        
        <header class="card-header border-0 card-header-gradient p-5 text-center">
            <div class="avatar-circle avatar-circle--2xl avatar-circle--bordered-lg mb-3 mx-auto shadow-lg avatar-profil">
                <?= strtoupper(substr($profil['nom'], 0, 1)) ?>
            </div>
            <h1 class="h3 fw-bold mb-1"><?= htmlspecialchars($profil['prenom'] . ' ' . $profil['nom']) ?></h1>
            <p class="mb-0 opacity-75">Membre depuis le <?= date('d/m/Y', strtotime($profil['date_inscription'])) ?></p>
        </header>

        <div class="card-body p-4 p-lg-5">
            <section aria-labelledby="infos-titre">
                <h2 id="infos-titre" class="h5 fw-bold mb-4 border-bottom pb-2">Informations personnelles</h2>
                
                <div class="row g-4">
                    <div class="col-12 d-flex align-items-center mb-2">
                        <div class="icon-box me-3 text-primary"><i class="bi bi-envelope-fill fs-5" aria-hidden="true"></i></div>
                        <div>
                            <span class="d-block small text-muted">Email</span>
                            <span class="fw-semibold"><?= htmlspecialchars($profil['email']) ?></span>
                        </div>
                    </div>

                    <div class="col-12 d-flex align-items-center mb-2">
                        <div class="icon-box me-3 text-primary"><i class="bi bi-telephone-fill fs-5" aria-hidden="true"></i></div>
                        <div>
                            <span class="d-block small text-muted">Téléphone</span>
                            <span class="fw-semibold"><?= !empty($profil['telephone']) ? htmlspecialchars($profil['telephone']) : 'Non renseigné' ?></span>
                        </div>
                    </div>

                    <div class="col-12 d-flex align-items-center mb-4">
                        <div class="icon-box me-3 text-primary"><i class="bi bi-geo-alt-fill fs-5" aria-hidden="true"></i></div>
                        <div>
                            <span class="d-block small text-muted">Adresse</span>
                            <span class="fw-semibold">
                                <?= !empty($profil['ville']) ? htmlspecialchars($profil['ville']) : 'Ville inconnue' ?> 
                                (<?= !empty($profil['code_postal']) ? htmlspecialchars($profil['code_postal']) : 'CP' ?>)
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <div class="pt-4 border-top">
                <a href="/profil/modifProfil" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                    <i class="bi bi-pencil-square me-2" aria-hidden="true"></i>Modifier mes informations
                </a>
            </div>
        </div>
    </div>
</main>