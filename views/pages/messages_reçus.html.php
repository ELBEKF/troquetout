<h1>Mes messages reçus</h1>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">Votre message a bien été envoyé !</p>
<?php endif; ?>

<?php if (empty($messages)): ?>
    <p>Vous n'avez reçu aucun message.</p>
<?php else: ?>
   <?php foreach ($messages as $msg): ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px 0; border-radius:5px; background-color:#f9f9f9;">
        <p><strong>Offre :</strong> <?= htmlspecialchars($msg['offer_title']) ?></p>
        <p><strong>De :</strong> <?= htmlspecialchars($msg['sender_name']) ?></p>
        <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
        <p><small>Reçu le : <?= date('d/m/Y H:i', strtotime($msg['date_sent'])) ?></small></p>

        <!-- Bouton répondre -->
        <button onclick="document.getElementById('reply-form-<?= $msg['id'] ?>').style.display='block'">
            Répondre
        </button>

        <!-- Formulaire de réponse caché -->
        <div id="reply-form-<?= $msg['id'] ?>" style="display:none; margin-top:10px;">
            <form action="/send_message.php" method="POST">
                <input type="hidden" name="to_user_id" value="<?= (int)$msg['sender_id'] ?>">
                <input type="hidden" name="offer_id" value="<?= (int)$msg['offer_id'] ?>">
                <textarea name="message" rows="4" cols="50" placeholder="Écrivez votre réponse ici..." required></textarea><br>
                <button type="submit">Envoyer</button>
                <button type="button" onclick="document.getElementById('reply-form-<?= $msg['id'] ?>').style.display='none'">Annuler</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>



<?php endif; ?>

