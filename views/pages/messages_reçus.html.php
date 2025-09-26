<!-- <div class="form-page"> -->
    
        <h2 class="form-title">Mes messages reçus</h2>

        <!-- Message de confirmation -->
        <?php if (isset($_GET['success'])): ?>
            <p class="form-success">Votre message a bien été envoyé !</p>
        <?php endif; ?>

        <!-- Si aucun message -->
        <?php if (empty($messages)): ?><div class="request-alert">
            <p class="form-info">Vous n'avez reçu aucun message.</p></div>

        <!-- Affichage des messages -->
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message-card">
                    <p><strong>Offre :</strong> <?= htmlspecialchars($msg['offer_title']) ?></p>
                    <p><strong>De :</strong> <?= htmlspecialchars($msg['sender_name']) ?></p>
                    <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                    <p class="message-date">Reçu le : <?= date('d/m/Y H:i', strtotime($msg['date_sent'])) ?></p>

                    <!-- Bouton "Répondre" -->
                    <div class="form-buttons">
                        <button type="button" class="form-submit" onclick="document.getElementById('reply-form-<?= $msg['id'] ?>').style.display='block'">
                            Répondre
                        </button>
                    </div>

                    <!-- Formulaire de réponse (caché par défaut) -->
                    <div id="reply-form-<?= $msg['id'] ?>" class="reply-form" style="display: none;">
                        <form method="POST" action="/send_message" class="form">
                            <input type="hidden" name="to_user_id" value="<?= (int)$msg['sender_id'] ?>">
                            <input type="hidden" name="offer_id" value="<?= (int)$msg['offer_id'] ?>">

                            <div class="form-group">
                                <label class="form-label" for="message">Votre réponse</label>
                                <textarea class="form-textarea" name="message" placeholder="Écrivez votre réponse ici..." required></textarea>
                            </div>

                            <div class="form-buttons">
                                <button type="submit" class="form-submit">Envoyer</button>
                                <button type="button" class="form-cancel" onclick="document.getElementById('reply-form-<?= $msg['id'] ?>').style.display='none'">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <h2 class="form-title">Mes messages envoyés</h2>

<?php if (empty($sent)): ?>
    <div class="request-alert">
        <p class="form-info">Vous n'avez envoyé aucun message.</p>
    </div>
<?php else: ?>
    <?php foreach ($sent as $msg): ?>
        <div class="message-card">
            <p><strong>Offre :</strong> <?= htmlspecialchars($msg['offer_title']) ?></p>
            <p><strong>À :</strong> <?= htmlspecialchars($msg['receiver_name']) ?></p>
            <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
            <p class="message-date">Envoyé le : <?= date('d/m/Y H:i', strtotime($msg['date_sent'])) ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</div>
