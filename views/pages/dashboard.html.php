
<main class="dashboard-container py-5" id="main-content">

    <header class="mb-5 text-center">
        <h1 class="display-5 fw-bold text-primary">Tableau de Bord</h1>
        <p class="text-muted">Gestion globale des utilisateurs et des annonces de la plateforme.</p>
    </header>

    <div class="row g-4">

        <aside class="col-lg-3" aria-label="Navigation du tableau de bord">
            <div class="card glass-effect p-3 border-0 sticky-top sidebar-sticky card-wrap--r-lg">

                <nav role="tablist" aria-label="Sections du tableau de bord" class="d-flex flex-column gap-2">

                    <button class="btn btn-primary text-start d-flex align-items-center active tab-button"
                            id="tab-users"
                            role="tab"
                            aria-selected="true"
                            aria-controls="usersSection"
                            data-tab="usersSection">
                        <i class="bi bi-people me-2" aria-hidden="true"></i>Utilisateurs
                        <span class="badge bg-white text-primary ms-auto"
                              aria-label="<?= count($users) ?> membres">
                            <?= count($users) ?>
                        </span>
                    </button>

                    <button class="btn btn-outline-primary text-start d-flex align-items-center tab-button"
                            id="tab-offers"
                            role="tab"
                            aria-selected="false"
                            aria-controls="offersSection"
                            data-tab="offersSection">
                        <i class="bi bi-card-list me-2" aria-hidden="true"></i>Annonces
                        <span class="badge bg-secondary ms-auto"
                              aria-label="<?= count($offers) ?> offres">
                            <?= count($offers) ?>
                        </span>
                    </button>

                </nav>
            </div>
        </aside>

        <div class="col-lg-9">

            <section id="usersSection"
                     class="card glass-effect border-0 shadow-sm mb-4 card-wrap--r-lg tab-content active"
                     role="tabpanel"
                     aria-labelledby="tab-users"
                     tabindex="0">

                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h2 class="h4 fw-bold mb-0">
                        Liste des Utilisateurs
                        <span class="text-muted fw-normal fs-6 ms-2">(<?= count($users) ?> membres)</span>
                    </h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-wrapper">
                        <table class="table table-hover align-middle mb-0"
                               aria-label="Liste des <?= count($users) ?> utilisateurs">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">ID</th>
                                    <th scope="col">Nom / Email</th>
                                    <th scope="col">Rôle</th>
                                    <th scope="col" class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="ps-4 text-muted small">
                                        #<?= (int)$user['id'] ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($user['nom']) ?></div>
                                        <div class="small text-muted"><?= htmlspecialchars($user['email']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill <?= $user['role'] === 'admin' ? 'bg-danger' : 'bg-info' ?>"
                                              aria-label="Rôle : <?= ucfirst($user['role']) ?>">
                                            <?= ucfirst($user['role']) ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group"
                                             aria-label="Actions pour <?= htmlspecialchars($user['nom']) ?>">
                                            <a href="/admin/modifUser/<?= (int)$user['id'] ?>"
                                               class="btn btn-sm btn-outline-warning"
                                               aria-label="Modifier <?= htmlspecialchars($user['nom']) ?>">
                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                            </a>
                                            <a href="admin/deleteUser/<?= (int)$user['id'] ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               aria-label="Supprimer <?= htmlspecialchars($user['nom']) ?>"
                                               data-confirm="Supprimer l'utilisateur « <?= htmlspecialchars($user['nom'], ENT_QUOTES) ?> » ?">
                                                <i class="bi bi-trash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="offersSection"
                     class="card glass-effect border-0 shadow-sm card-wrap--r-lg tab-content hidden"
                     role="tabpanel"
                     aria-labelledby="tab-offers"
                     tabindex="0">

                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h2 class="h4 fw-bold mb-0">
                        Gestion des Annonces
                        <span class="text-muted fw-normal fs-6 ms-2">(<?= count($offers) ?> offres)</span>
                    </h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-wrapper">
                        <table class="table table-hover align-middle mb-0"
                               aria-label="Liste des <?= count($offers) ?> annonces">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">Titre</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Localisation</th>
                                    <th scope="col" class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($offers as $o): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold truncate-200">
                                            <?= htmlspecialchars($o['titre']) ?>
                                        </div>
                                    </td>
                                    <td><?= ucfirst(htmlspecialchars($o['type'])) ?></td>
                                    <td>
                                        <i class="bi bi-geo-alt small me-1" aria-hidden="true"></i>
                                        <?= htmlspecialchars($o['localisation']) ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group"
                                             aria-label="Actions pour l'annonce « <?= htmlspecialchars($o['titre'], ENT_QUOTES) ?> »">
                                            <a href="/offers/detail/<?= (int)$o['id'] ?>"
                                               class="btn btn-sm btn-outline-primary"
                                               aria-label="Voir l'annonce : <?= htmlspecialchars($o['titre'], ENT_QUOTES) ?>">
                                                <i class="bi bi-eye" aria-hidden="true"></i>
                                            </a>
                                            <a href="/offers/modifoffer/<?= (int)$o['id'] ?>"
                                               class="btn btn-sm btn-outline-warning"
                                               aria-label="Modifier l'annonce : <?= htmlspecialchars($o['titre'], ENT_QUOTES) ?>">
                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                            </a>
                                            <a href="/admin/deleteOffer/<?= (int)$o['id'] ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               aria-label="Supprimer l'annonce : <?= htmlspecialchars($o['titre'], ENT_QUOTES) ?>"
                                               data-confirm="Supprimer l'annonce « <?= htmlspecialchars($o['titre'], ENT_QUOTES) ?> » ?">
                                                <i class="bi bi-trash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </div>
</main>