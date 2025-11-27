<link rel="stylesheet" href="/css/homepage.css"> <!-- variables globales : charger avant -->
<link rel="stylesheet" href="/css/inscription.css">

<!-- Wrapper principal (IMPORTANT : ne pas commenter) -->

  <div class="form-container">
    <h2 class="form-title">Inscription</h2>

    <?php if (!empty($error)): ?>
        <p class="form-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form class="form" action="/inscription" method="POST">
      <div class="form-group">
        <label class="form-label" for="nom">Nom <span class="form-required">*</span></label>
        <input class="form-input" type="text" name="nom" id="nom" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="prenom">Prénom <span class="form-required">*</span></label>
        <input class="form-input" type="text" name="prenom" id="prenom" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="email">Email <span class="form-required">*</span></label>
        <input class="form-input" type="email" name="email" id="email" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Mot de passe <span class="form-required">*</span></label>
        <input class="form-input" type="password" name="password" id="password" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="telephone">Téléphone</label>
        <input class="form-input" type="tel" name="telephone" id="telephone">
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="ville">Ville</label>
          <input class="form-input" type="text" name="ville" id="ville">
        </div>

        <div class="form-group">
          <label class="form-label" for="code_postal">Code postal</label>
          <input class="form-input" type="text" name="code_postal" id="code_postal">
        </div>
      </div>

      <div class="form-buttons">
        <input type="submit" value="S'inscrire" class="btn btn-primary">
      </div>
    </form>
  </div>

