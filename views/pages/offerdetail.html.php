<?php session_start(); ?>

<div>
    <div>
        <h1>
            <i class="fa-solid fa-box-open"></i> <?= htmlspecialchars($detail['titre']) ?>
        </h1>
        <p>Découvrez tous les détails de cette offre</p>
    </div>

    <div>
        <div>
            <div>
                <?php if (!empty($detail["photo"])): ?>
                    <img src="<?= htmlspecialchars($detail["photo"]) ?>" alt="Image de l'offre" style="max-width: 100%; height: auto;">
                <?php else: ?>
                    <div>Aucune image disponible</div>
                <?php endif; ?>
            </div>

            <div>
                <h3>Description</h3>
                <p><?= nl2br(htmlspecialchars($detail["description"])) ?></p>

                <div>
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

                <!-- Formulaire de contact -->
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $detail['user_id']): ?>
                    <h2>Contacter l’offreur</h2>
                    <form action="/send_message.php" method="POST">
                        <input type="hidden" name="to_user_id" value="<?= (int)$detail['user_id'] ?>">
                        <input type="hidden" name="offer_id" value="<?= (int)$detail['id'] ?>">
                        <textarea name="message" required placeholder="Écrivez votre message ici..." rows="5" cols="50" style="width:100%;"></textarea><br>
                        <button type="submit">Envoyer le message</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
