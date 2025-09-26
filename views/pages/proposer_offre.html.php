<h2 class="offer-title">Proposer une offre</h2>

<?php if (!empty($error)): ?>
    <div class="offer-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="offer-box">
    <form action="/demande/proposer/<?= htmlspecialchars($request_id) ?>" method="post" class="offer-form">

        <input type="hidden" name="request_id" value="<?= htmlspecialchars($request_id) ?>">

        <div class="offer-field">
            <label for="offre_id" class="offer-label">Choisissez votre offre :</label>
            <select name="offre_id" id="offre_id" class="offer-select" required>
                <option value="">-- Sélectionnez une offre --</option>
                <?php foreach ($offres as $offre): ?>
                    <option value="<?= $offre['id'] ?>"><?= htmlspecialchars($offre['titre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="offer-field">
            <label for="message" class="offer-label">Message :</label>
            <textarea name="message" id="message" class="offer-textarea" required></textarea>
        </div>

        <div class="offer-actions">
            <button type="submit" class="offer-btn">Envoyer</button>
        </div>
    </form>
</div>
