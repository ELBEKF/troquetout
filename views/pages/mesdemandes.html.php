
<main class="container py-5">
    <header class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
        <div>
            <h1 class="h2 fw-bold mb-1">Mes Demandes</h1>
            <p class="text-muted mb-0">Retrouvez et gérez les besoins que vous avez publiés.</p>
        </div>
        <a href="/demande/create/" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-2" aria-hidden="true"></i>Nouvelle demande
        </a>
    </header>

    <?php if (empty($requests)): ?>
        <div class="card glass-effect border-0 text-center p-5 shadow-sm card-wrap">
            <div class="mb-4">
                <i class="bi bi-chat-left-dots text-muted icon-xl" aria-hidden="true"></i>
            </div>
            <h2 class="h4 fw-bold">Vous n'avez pas encore de demandes</h2>
            <p class="text-muted mx-auto mb-4 text-narrow">
                Si vous avez besoin d'un objet ou d'un service, publiez une annonce pour solliciter la communauté.
            </p>
            <a href="/demande/create/" class="btn btn-outline-primary px-4">Créer ma première demande</a>
        </div>
    <?php else: ?>

    <div class="card glass-effect border-0 shadow-sm overflow-hidden card-wrap--r-lg">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th scope="col" class="ps-4 py-3">Titre de la demande</th>
                        <th scope="col" class="py-3">Type</th>
                        <th scope="col" class="py-3">Date prévue</th>
                        <th scope="col" class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $req): ?>
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold d-block text-truncate truncate-250">
                                <?= htmlspecialchars($req['titre']) ?>
                            </span>
                            <small class="text-muted">Posté le : <?= date('d/m/Y', strtotime($req['created_at'] ?? 'now')) ?></small>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-info-subtle text-info px-3">
                                <?= ucfirst(htmlspecialchars($req['type_demande'])) ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar-event me-2 text-primary" aria-hidden="true"></i>
                                <span><?= htmlspecialchars($req['date_besoin']) ?></span>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="/demande/editdemande/<?= $req['id'] ?>" 
                                   class="btn btn-sm btn-warning shadow-sm" 
                                   title="Modifier cette demande"
                                   aria-label="Modifier">
                                    <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                </a>

                                <form action="/demande/delete/<?= $req['id'] ?>" method="POST" class="d-inline">
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Supprimer cette demande"
                                            data-confirm="Êtes-vous sûr de vouloir supprimer cette demande ? Cette action est irréversible."
                                            aria-label="Supprimer">
                                        <i class="bi bi-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</main>