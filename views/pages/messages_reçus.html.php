<link rel="stylesheet" href="/css/message.css">

<div class="messaging-container">

    <!-- NOUVEAU : Header avec onglets -->
    <div class="messaging-header">
        <h1 class="header-title">
            <svg class="header-icon" viewBox="0 0 24 24" fill="none" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
            Messagerie
        </h1>
        
        <div class="tabs-container">
            <button class="tab-button active" data-tab="received">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                Messages reçus
                <?php if (!empty($messages)): ?>
                    <span class="tab-badge"><?= count($messages) ?></span>
                <?php endif; ?>
            </button>
            
            <button class="tab-button" data-tab="sent">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
                Messages envoyés
                <?php if (!empty($sent)): ?>
                    <span class="tab-badge"><?= count($sent) ?></span>
                <?php endif; ?>
            </button>
        </div>
    </div>

    <!-- Message de confirmation -->
    <?php if (isset($_GET['success'])): ?>
        <div class="form-success">
            Votre message a bien été envoyé !
        </div>
    <?php endif; ?>

    <!-- Conteneur pour les onglets -->
    <div class="tabs-content-wrapper">
        <!-- Section Messages Reçus -->
        <section id="received" class="message-section tab-content active">
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
                <div class="messages-list" id="received-messages-list">
                    <?php foreach ($messages as $index => $msg): ?>
                        <div class="message-item" onclick="toggleMessage('msg-<?= $msg['id'] ?>')" <?= $index >= 4 ? 'style="display:none;"' : '' ?>>
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
                                            <button type="button" class="form-cancel" onclick="event.stopPropagation(); hideReplyForm('reply-<?= $msg['id'] ?>', 'msg-<?= $msg['id'] ?>')">Annuler</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($messages) > 3): ?>
                    <div class="see-more-wrapper text-center mt-3">
                        <button id="load-more-received" class="btn btn-outline-primary">Voir plus</button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </section>

        <!-- Section Messages Envoyés -->
        <section id="sent" class="message-section tab-content">
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
                <div class="messages-list" id="sent-messages-list">
                    <?php foreach ($sent as $index => $msg): ?>
                        <div class="message-item message-sent" onclick="toggleMessage('sent-<?= $msg['id'] ?>')" <?= $index >= 3 ? 'style="display:none;"' : '' ?>>
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
                <?php if (count($sent) > 3): ?>
                    <div class="see-more-wrapper text-center mt-3">
                        <button id="load-more-sent" class="btn btn-outline-primary">Voir plus</button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </section>
    </div>

</div>

<script>
// Gestion des onglets
const tabButtons = document.querySelectorAll('.tab-button');
const tabContents = document.querySelectorAll('.tab-content');

tabButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Retirer la classe active de tous les boutons et contenus
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));

        // Ajouter la classe active au bouton cliqué
        button.classList.add('active');

        // Afficher le contenu correspondant
        const tabId = button.getAttribute('data-tab');
        const targetContent = document.getElementById(tabId);
        if (targetContent) {
            targetContent.classList.add('active');
        }
    });
});

// Votre code existant
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

// Voir plus pour messages reçus
document.getElementById('load-more-received')?.addEventListener('click', function() {
    const list = document.getElementById('received-messages-list');
    const hiddenMessages = list.querySelectorAll('.message-item[style*="display:none"]');
    const nextBatch = Array.from(hiddenMessages).slice(0, 3);
    nextBatch.forEach(msg => msg.style.display = 'block');
    if (list.querySelectorAll('.message-item[style*="display:none"]').length === 0) this.style.display = 'none';
});

// Voir plus pour messages envoyés
document.getElementById('load-more-sent')?.addEventListener('click', function() {
    const list = document.getElementById('sent-messages-list');
    const hiddenMessages = list.querySelectorAll('.message-item[style*="display:none"]');
    const nextBatch = Array.from(hiddenMessages).slice(0, 3);
    nextBatch.forEach(msg => msg.style.display = 'block');
    if (list.querySelectorAll('.message-item[style*="display:none"]').length === 0) this.style.display = 'none';
});
</script>