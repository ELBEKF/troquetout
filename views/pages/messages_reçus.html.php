<link rel="stylesheet" href="/css/message.css">

<div class="messaging-container">
    
    <!-- Message de confirmation -->
    <?php if (isset($_GET['success'])): ?>
        <div class="form-success">
            Votre message a bien été envoyé !
        </div>
    <?php endif; ?>

    <!-- Section Messages Reçus -->
    <section class="message-section">
        <div class="section-header">
            <h2 class="section-title">
                <svg class="title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                Messages reçus
            </h2>
            <?php if (!empty($messages)): ?>
                <span class="message-count"><?= count($messages) ?></span>
            <?php endif; ?>
        </div>

        <?php if (empty($messages)): ?>
            <div class="request-alert">
                <p class="form-info">Vous n'avez reçu aucun message.</p>
            </div>
        <?php else: ?>
            <div class="messages-list">
                <?php foreach ($messages as $msg): ?>
                    <div class="message-item" onclick="toggleMessage('msg-<?= $msg['id'] ?>')">
                        <div class="message-preview">
                            <div class="avatar"><?= strtoupper(substr($msg['sender_name'], 0, 1)) ?></div>
                            <div class="preview-content">
                                <p class="preview-sender"><?= htmlspecialchars($msg['sender_name']) ?></p>
                                <p class="preview-offer"><?= htmlspecialchars($msg['offer_title']) ?></p>
                                <p class="preview-date"><?= date('d/m/Y H:i', strtotime($msg['date_sent'])) ?></p>
                            </div>
                            <svg class="expand-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>

                        <div id="msg-<?= $msg['id'] ?>" class="message-details" style="display: none;">
                            <div class="message-content">
                                <?= nl2br(htmlspecialchars($msg['message'])) ?>
                            </div>

                            <div class="form-buttons">
                                <button type="button" class="form-submit" onclick="event.stopPropagation(); showReplyForm('reply-<?= $msg['id'] ?>'); this.style.display='none'">
                                    Répondre
                                </button>
                            </div>

                            <!-- Formulaire de réponse -->
                            <div id="reply-<?= $msg['id'] ?>" class="reply-form" style="display: none;">
                                <form method="POST" action="/send_message" class="form" onclick="event.stopPropagation()">
                                    <input type="hidden" name="to_user_id" value="<?= (int)$msg['sender_id'] ?>">
                                    <input type="hidden" name="offer_id" value="<?= (int)$msg['offer_id'] ?>">

                                    <div class="form-group">
                                        <label class="form-label">Votre réponse</label>
                                        <textarea class="form-textarea" name="message" placeholder="Écrivez votre réponse ici..." required></textarea>
                                    </div>

                                    <div class="form-buttons">
                                        <button type="submit" class="form-submit">Envoyer</button>
                                        <button type="button" class="form-cancel" onclick="event.stopPropagation(); hideReplyForm('reply-<?= $msg['id'] ?>', 'msg-<?= $msg['id'] ?>')">
                                            Annuler
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- Section Messages Envoyés -->
    <section class="message-section">
        <div class="section-header">
            <h2 class="section-title">
                <svg class="title-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
                Messages envoyés
            </h2>
            <?php if (!empty($sent)): ?>
                <span class="message-count"><?= count($sent) ?></span>
            <?php endif; ?>
        </div>

        <?php if (empty($sent)): ?>
            <div class="request-alert">
                <p class="form-info">Vous n'avez envoyé aucun message.</p>
            </div>
        <?php else: ?>
            <div class="messages-list">
                <?php foreach ($sent as $msg): ?>
                    <div class="message-item message-sent" onclick="toggleMessage('sent-<?= $msg['id'] ?>')">
                        <div class="message-preview">
                            <div class="avatar avatar-sent"><?= strtoupper(substr($msg['receiver_name'], 0, 1)) ?></div>
                            <div class="preview-content">
                                <p class="preview-sender">À : <?= htmlspecialchars($msg['receiver_name']) ?></p>
                                <p class="preview-offer"><?= htmlspecialchars($msg['offer_title']) ?></p>
                                <p class="preview-date"><?= date('d/m/Y H:i', strtotime($msg['date_sent'])) ?></p>
                            </div>
                            <svg class="expand-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>

                        <div id="sent-<?= $msg['id'] ?>" class="message-details" style="display: none;">
                            <div class="message-content">
                                <?= nl2br(htmlspecialchars($msg['message'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

</div>

<script>
function toggleMessage(id) {
    const details = document.getElementById(id);
    const item = details.closest('.message-item');
    const icon = item.querySelector('.expand-icon');
    
    if (details.style.display === 'none') {
        details.style.display = 'block';
        item.classList.add('expanded');
        icon.style.transform = 'rotate(180deg)';
    } else {
        details.style.display = 'none';
        item.classList.remove('expanded');
        icon.style.transform = 'rotate(0deg)';
    }
}

function showReplyForm(id) {
    const form = document.getElementById(id);
    form.style.display = 'block';
}

function hideReplyForm(replyId, msgId) {
    const form = document.getElementById(replyId);
    const msg = document.getElementById(msgId);
    const btn = msg.querySelector('.form-submit');
    
    form.style.display = 'none';
    if (btn) btn.style.display = 'inline-flex';
}
</script>