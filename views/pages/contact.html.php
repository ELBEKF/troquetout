
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <section class="card glass-effect shadow-lg border-0 card-wrap card-wrap--overflow">
                
                <div class="row g-0">
                    <div class="col-md-4 bg-primary text-white p-4 d-flex flex-column justify-content-center">
                        <h2 class="h4 fw-bold mb-4">Contactez-nous</h2>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="bi bi-geo-alt-fill me-2" aria-hidden="true"></i> Paris, France
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-envelope-fill me-2" aria-hidden="true"></i> support@troquetout.fr
                            </li>
                            <li>
                                <i class="bi bi-clock-fill me-2" aria-hidden="true"></i> 24h/24 - 7j/7
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-8 p-4 p-lg-5">
                        <header class="mb-4">
                            <h1 class="h3 fw-bold"><?= htmlspecialchars($title) ?></h1>
                            <p class="text-muted">Une question ? Une suggestion ? Écrivez-nous.</p>
                        </header>

                        <form action="/sendcontact" method="POST" class="modern-form">
                            
                            <div class="mb-3">
                                <label for="nom" class="form-label fw-semibold">Votre Nom</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="bi bi-person text-muted" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" name="nom" id="nom" 
                                           class="form-control border-start-0" 
                                           placeholder="Jean Dupont" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Votre Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="bi bi-envelope text-muted" aria-hidden="true"></i>
                                    </span>
                                    <input type="email" name="email" id="email" 
                                           class="form-control border-start-0" 
                                           placeholder="jean.dupont@exemple.com" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label fw-semibold">Votre Message</label>
                                <textarea name="message" id="message" rows="5" 
                                          class="form-control" 
                                          placeholder="Comment pouvons-nous vous aider ?" required></textarea>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                                    <i class="bi bi-send me-2" aria-hidden="true"></i> Envoyer le message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </section>
        </div>
    </div>
</main>