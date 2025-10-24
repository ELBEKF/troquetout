<link rel="stylesheet" href="/css/detailoffer.css">

<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- <div class="offer-detail"> -->
    <div class="offer-header">
        <h1 class="offer-title">
            <i class="fa-solid fa-box-open"></i>
            <?= htmlspecialchars($detail['titre']) ?>
        </h1>
        <p class="offer-subtitle">Découvrez tous les détails de cette offre</p>
    </div>

    <div class="offer-content">
        <div class="offer-main">
            <div class="offer-image">
                <?php if (!empty($detail["photo"])): ?>
                    <img src="<?= htmlspecialchars($detail["photo"]) ?>" alt="Image de l'offre">
                <?php else: ?>
                    <div class="no-image">Aucune image disponible</div>
                <?php endif; ?>
            </div>

            <div class="offer-info">
                <h3 class="offer-section-title">Description</h3>
                <p class="offer-description"><?= nl2br(htmlspecialchars($detail["description"])) ?></p>

                <div class="offer-details">
                    <div><strong>Type d’offre :</strong> <?= htmlspecialchars($detail["type"]) ?></div>
                    <div><strong>Sens :</strong> <?= htmlspecialchars($detail["sens"]) ?></div>
                    <div><strong>Catégorie :</strong> <?= htmlspecialchars($detail["categorie"]) ?></div>
                    <div><strong>État :</strong> <?= htmlspecialchars($detail["etat"]) ?></div>
                    <div><strong>Prix :</strong> <?= number_format($detail["prix"], 2) ?> €</div>
                    <div><strong>Caution :</strong> <?= number_format($detail["caution"], 2) ?> €</div>
                    <div><strong>Localisation :</strong> <?= htmlspecialchars($detail["localisation"]) ?></div>
                    <div><strong>Disponibilité jusqu’au :</strong> <?= htmlspecialchars($detail["disponibilite"]) ?></div>
                    <div><strong>Date de création :</strong> <?= date("d/m/Y", strtotime($detail["date_creation"])) ?></div>
                </div>

                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $detail['user_id']): ?>
                    <h2 class="contact-title">Contacter l’offreur</h2>
                    <form class="contact-form" action="/send_message/" method="POST">
                        <input type="hidden" name="to_user_id" value="<?= (int)$detail['user_id'] ?>">
                        <input type="hidden" name="offer_id" value="<?= (int)$detail['id'] ?>">
                        <textarea class="form-textarea" name="message" required placeholder="Écrivez votre message ici..." rows="5" cols="50"></textarea><br>
                        <button type="submit" class="contact-button">Envoyer le message</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
