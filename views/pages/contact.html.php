<link rel="stylesheet" href="/css/contact.css">


<link rel="stylesheet" href="./css/connexion.css">

    <div class="form-container">
        <h2 class="form-title"><?= htmlspecialchars($title) ?></h2>

        <?php if (!empty($_SESSION['contact_success'])): ?>
            <p class="form-success"><?= htmlspecialchars($_SESSION['contact_success']) ?></p>
            <?php unset($_SESSION['contact_success']); ?>
        <?php endif; ?>

        <form class="form" action="/sendcontact" method="POST">
            <div class="form-group">
                <label class="form-label" for="nom">Nom <span class="form-required">*</span></label>
                <input class="form-input" type="text" name="nom" id="nom" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email <span class="form-required">*</span></label>
                <input class="form-input" type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="message">Message <span class="form-required">*</span></label>
                <textarea class="form-textarea" name="message" id="message" rows="5" required></textarea>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </form>
    </div>

