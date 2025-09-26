<!-- <div class="form-page"> -->
    
        <h2 class="form-title"><?= htmlspecialchars($title) ?></h2>
        <div class="offres-wrapper p-4 my-4">
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="offers/addOffer" class="btn btn-primary mb-4">
        Ajouter une offre
      </a>
    <?php else: ?>
      <button class="btn btn-outline-secondary w-100 mb-4" disabled>
        🔒 Connectez-vous pour ajouter une offre
      </button>
    <?php endif; ?>
<p class="explique">
  Retrouvez et gérez toutes vos annonces facilement.<br>
  Vous pouvez publier de nouveaux objets, mettre à jour leur état ou les retirer une fois échangés.<br>
  Plus vos annonces sont claires, plus vos chances d’échange augmentent !
</p><br>
        <?php if (empty($offers)): ?>
            <div class="request-alert"><p class="form-info">Vous n'avez publié aucune offre pour le moment.</p></div>
        <?php else: ?>
            <?php foreach ($offers as $offre): ?>
                <div class="offer-card">
                    <!-- Image de l'offre -->
                    <div class="offer-thumbnail">
                        <img src="<?= htmlspecialchars($offre['photo']) ?>" alt="Photo de l'offre" class="offer-image">
                    </div>

                    <!-- Contenu principal -->
                    <div class="offer-details">
                        <h3 class="offer-title"><?= htmlspecialchars($offre['titre']) ?></h3>

                        <p><strong>Type :</strong> <span class="offer-type"><?= htmlspecialchars($offre['type']) ?></span></p>
                        <p class="offer-date"><strong>Publiée le :</strong> <?= date('d/m/Y', strtotime($offre['date_creation'])) ?></p>

                        <div class="offer-description">
                            <?= nl2br(htmlspecialchars($offre['description'])) ?>
                        </div>

                        <!-- Boutons -->
                        <div class="offer-actions">
                            <a href="/offers/modifoffer/<?= urlencode($offre['id']) ?>" class="offer-btn offer-edit">
                                 Modifier
                            </a>
                            <a href="/deleteOffer/<?= urlencode($offre['id']) ?>" class="offer-btn offer-delete"
                               onclick="return confirm('Supprimer cette offre ?');">
                                 Supprimer
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
   
</div>
