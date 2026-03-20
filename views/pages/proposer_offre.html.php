
<main class="container py-5">
    <div class="card glass-effect mx-auto shadow-lg card-wrap card-wrap--md">
        
        <header class="card-header bg-transparent border-0 pt-5 px-4 text-center">
            <div class="avatar-circle avatar-circle--lg avatar-gradient avatar-circle--bordered mb-3 mx-auto shadow-sm">
                <?= isset($_SESSION['user_nom']) ? strtoupper(substr($_SESSION['user_nom'], 0, 1)) : 'E' ?>
            </div>
            <h1 class="h2 fw-bold mb-0">Proposer mon aide</h1>
            <p class="text-muted mt-2">Répondez à la demande #<?= htmlspecialchars($request_id) ?> avec l'une de vos annonces.</p>
        </header>

        <div class="card-body p-4 p-lg-5">
            <form action="/demande/proposer/<?= htmlspecialchars($request_id) ?>" method="POST" class="modern-form">

                <input type="hidden" name="request_id" value="<?= htmlspecialchars($request_id) ?>">

                <div class="mb-4">
                    <label for="offre_id" class="form-label fw-bold">Laquelle de vos offres souhaitez-vous proposer ? <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-box-seam text-muted" aria-hidden="true"></i></span>
                        <select name="offre_id" id="offre_id" class="form-select border-start-0" required aria-required="true">
                            <option value="" disabled selected>-- Choisir une annonce --</option>
                            <?php foreach ($offres as $offre): ?>
                                <option value="<?= $offre['id'] ?>"><?= htmlspecialchars($offre['titre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-text mt-2">Seules vos offres actives apparaissent ici.</div>
                </div>

                <div class="mb-4">
                    <label for="message" class="form-label fw-bold">Votre message d'accompagnement <span class="text-danger">*</span></label>
                    <textarea name="message" id="message" class="form-control" rows="5" 
                              placeholder="Bonjour, je pense que mon annonce pourrait vous intéresser car..." required aria-required="true"></textarea>
                    <div class="form-text">Présentez brièvement pourquoi votre objet correspond au besoin.</div>
                </div>

                <div class="d-flex flex-column flex-md-row gap-3 mt-5 pt-3 border-top">
                    <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold flex-grow-1 shadow-sm">
                        <i class="bi bi-send-fill me-2" aria-hidden="true"></i>Envoyer ma proposition
                    </button>
                    <a href="/demandes" class="btn btn-outline-secondary btn-lg px-4">
                        Annuler
                    </a>
                </div>

            </form>
        </div>
    </div>
</main>