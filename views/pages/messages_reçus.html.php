<main class="messaging-container py-5">
    <div class="container">

        <header class="messaging-header mb-5 card glass-effect border-0 p-4 shadow-sm card-wrap">
            <div class="d-flex align-items-center mb-4">
                <div class="icon-box bg-primary text-white rounded-circle p-3 me-3 shadow-sm"
                     aria-hidden="true">
                    <i class="bi bi-chat-left-dots fs-4" aria-hidden="true"></i>
                </div>
                <h1 class="h2 fw-bold mb-0">Ma Messagerie</h1>
            </div>

            <div class="tabs-container d-flex gap-2" role="tablist" aria-label="Sections de messagerie">

                <button class="btn tab-button active flex-grow-1 d-flex align-items-center justify-content-center py-2 btn-primary"
                        id="tab-received"
                        role="tab"
                        aria-selected="true"
                        aria-controls="received"
                        data-tab="received">
                    <i class="bi bi-inbox me-2" aria-hidden="true"></i>
                    Messages reçus
                    <?php if (!empty($messages)): ?>
                        <span class="badge bg-white text-primary ms-2"
                              aria-label="<?= count($messages) ?> message<?= count($messages) > 1 ? 's' : '' ?>">
                            <?= count($messages) ?>
                        </span>
                    <?php endif; ?>
                </button>

                <button class="btn tab-button flex-grow-1 d-flex align-items-center justify-content-center py-2 btn-outline-primary"
                        id="tab-sent"
                        role="tab"
                        aria-selected="false"
                        aria-controls="sent"
                        data-tab="sent">
                    <i class="bi bi-send me-2" aria-hidden="true"></i>
                    Messages envoyés
                    <?php if (!empty($sent)): ?>
                        <span class="badge bg-secondary ms-2"
                              aria-label="<?= count($sent) ?> message<?= count($sent) > 1 ? 's' : '' ?> envoyé<?= count($sent) > 1 ? 's' : '' ?>">
                            <?= count($sent) ?>
                        </span>
                    <?php endif; ?>
                </button>
            </div>
        </header>

        <div class="tabs-content-wrapper">

            <section id="received"
                     class="tab-content active"
                     role="tabpanel"
                     aria-labelledby="tab-received"
                     tabindex="0">

                <?php if (empty($messages)): ?>
                    <div class="alert glass-effect text-center p-5 border-0 shadow-sm card-wrap">
                        <i class="bi bi-mailbox display-1 text-muted opacity-50 mb-3" aria-hidden="true"></i>
                        <p class="fs-5 text-muted">Votre boîte de réception est vide.</p>
                    </div>
                <?php else: ?>
                    <div class="messages-list d-flex flex-column gap-3"
                         aria-label="Liste des messages reçus">
                        <?php foreach ($messages as $msg): ?>
                            <article class="message-item card glass-effect border-0 shadow-sm overflow-hidden card-wrap--r-lg">

                                <div class="message-preview p-3 d-flex align-items-center cursor-pointer"
                                     data-target="msg-received-<?= (int)$msg['id'] ?>"
                                     role="button"
                                     tabindex="0"
                                     aria-expanded="false"
                                     aria-controls="msg-received-<?= (int)$msg['id'] ?>"
                                     aria-label="Message de <?= htmlspecialchars($msg['sender_name']) ?> — cliquer pour ouvrir">

                                    <div class="avatar-circle avatar-circle--sm avatar-gradient me-3 flex-shrink-0"
                                         aria-hidden="true">
                                        <?= strtoupper(substr($msg['sender_name'], 0, 1)) ?>
                                    </div>

                                    <div class="preview-content flex-grow-1 overflow-hidden">
                                        <h2 class="h6 fw-bold mb-0 text-truncate">
                                            <?= htmlspecialchars($msg['sender_name']) ?>
                                        </h2>
                                        <p class="small text-primary mb-0 text-truncate">
                                            Re&nbsp;: <?= htmlspecialchars($msg['offer_title']) ?>
                                        </p>
                                        <time class="small text-muted"
                                              datetime="<?= date('Y-m-d\TH:i', strtotime($msg['date_sent'])) ?>">
                                            <?= date('d/m/Y à H:i', strtotime($msg['date_sent'])) ?>
                                        </time>
                                    </div>

                                    <i class="bi bi-chevron-down expand-icon ms-2" aria-hidden="true"></i>
                                </div>

                                <div id="msg-received-<?= (int)$msg['id'] ?>"
                                     class="message-details p-4 pt-0 msg-body-hidden"
                                     role="region"
                                     aria-label="Contenu du message de <?= htmlspecialchars($msg['sender_name']) ?>">

                                    <div class="message-body bg-white bg-opacity-50 p-3 rounded-3 mb-3 border">
                                        <?= nl2br(htmlspecialchars($msg['message'])) ?>
                                    </div>

                                    <div class="actions">
                                        <button type="button"
                                                class="btn btn-sm btn-primary px-4 fw-bold reply-btn"
                                                data-reply-target="reply-<?= (int)$msg['id'] ?>"
                                                aria-label="Répondre à <?= htmlspecialchars($msg['sender_name']) ?>">
                                            <i class="bi bi-reply-fill me-1" aria-hidden="true"></i>Répondre
                                        </button>
                                    </div>

                                    <div id="reply-<?= (int)$msg['id'] ?>"
                                         class="reply-form mt-4 border-top pt-3 msg-body-hidden"
                                         role="region"
                                         aria-label="Formulaire de réponse">
                                        <form method="POST" action="/send_message"
                                              aria-label="Répondre à <?= htmlspecialchars($msg['sender_name']) ?>">
                                            <input type="hidden" name="to_user_id" value="<?= (int)$msg['sender_id'] ?>">
                                            <input type="hidden" name="offer_id"   value="<?= (int)$msg['offer_id'] ?>">

                                            <div class="mb-3">
                                                <label class="form-label fw-bold small"
                                                       for="reply-textarea-<?= (int)$msg['id'] ?>">
                                                    Votre réponse <span class="text-danger" aria-label="champ obligatoire">*</span>
                                                </label>
                                                <textarea class="form-control"
                                                          id="reply-textarea-<?= (int)$msg['id'] ?>"
                                                          name="message"
                                                          rows="3"
                                                          required
                                                          aria-required="true"
                                                          placeholder="Tapez votre message ici…"></textarea>
                                            </div>

                                            <div class="d-flex gap-2">
                                                <button type="submit"
                                                        class="btn btn-sm btn-success flex-grow-1 fw-bold"
                                                        aria-label="Envoyer la réponse à <?= htmlspecialchars($msg['sender_name']) ?>">
                                                    <i class="bi bi-send me-1" aria-hidden="true"></i>Envoyer
                                                </button>
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-secondary cancel-reply-btn"
                                                        data-reply-id="reply-<?= (int)$msg['id'] ?>"
                                                        aria-label="Annuler la réponse">
                                                    Annuler
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <section id="sent"
                     class="tab-content hidden"
                     role="tabpanel"
                     aria-labelledby="tab-sent"
                     tabindex="0">

                <?php if (empty($sent)): ?>
                    <div class="alert glass-effect text-center p-5 border-0 shadow-sm card-wrap">
                        <i class="bi bi-send-x display-1 text-muted opacity-50 mb-3" aria-hidden="true"></i>
                        <p class="fs-5 text-muted">Vous n'avez envoyé aucun message.</p>
                    </div>
                <?php else: ?>
                    <div class="messages-list d-flex flex-column gap-3"
                         aria-label="Liste des messages envoyés">
                        <?php foreach ($sent as $msg): ?>
                            <article class="message-item card glass-effect border-0 shadow-sm overflow-hidden card-wrap--r-lg">

                                <div class="message-preview p-3 d-flex align-items-center cursor-pointer"
                                     data-target="msg-sent-<?= (int)$msg['id'] ?>"
                                     role="button"
                                     tabindex="0"
                                     aria-expanded="false"
                                     aria-controls="msg-sent-<?= (int)$msg['id'] ?>"
                                     aria-label="Message envoyé à <?= htmlspecialchars($msg['receiver_name'] ?? 'Utilisateur') ?> — cliquer pour ouvrir">

                                    <div class="avatar-circle avatar-circle--sm avatar-neutral me-3 flex-shrink-0"
                                         aria-hidden="true">
                                        <?= strtoupper(substr($msg['receiver_name'] ?? 'U', 0, 1)) ?>
                                    </div>

                                    <div class="preview-content flex-grow-1 overflow-hidden">
                                        <h2 class="h6 fw-bold mb-0 text-truncate">
                                            À&nbsp;: <?= htmlspecialchars($msg['receiver_name'] ?? 'Utilisateur') ?>
                                        </h2>
                                        <p class="small text-muted mb-0 text-truncate">
                                            Objet&nbsp;: <?= htmlspecialchars($msg['offer_title'] ?? 'Annonce') ?>
                                        </p>
                                        <time class="small text-muted"
                                              datetime="<?= date('Y-m-d\TH:i', strtotime($msg['date_sent'])) ?>">
                                            <?= date('d/m/Y à H:i', strtotime($msg['date_sent'])) ?>
                                        </time>
                                    </div>

                                    <i class="bi bi-chevron-down expand-icon ms-2" aria-hidden="true"></i>
                                </div>

                                <div id="msg-sent-<?= (int)$msg['id'] ?>"
                                     class="message-details p-4 pt-0 msg-body-hidden"
                                     role="region"
                                     aria-label="Contenu du message envoyé à <?= htmlspecialchars($msg['receiver_name'] ?? 'Utilisateur') ?>">
                                    <div class="message-body bg-light p-3 rounded-3 border">
                                        <p class="small text-muted mb-2"><em>Votre message :</em></p>
                                        <?= nl2br(htmlspecialchars($msg['message'])) ?>
                                    </div>
                                </div>

                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

        </div>
    </div>
</main>