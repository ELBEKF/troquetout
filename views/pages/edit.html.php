<!-- <div class="form-page"> -->
<h2 class="form-title">Modifier votre demande</h2>

<form method="post">
    <div>
        <label class="form-label" for="titre">Titre</label>
        <input class="form-input" type="text" name="titre" id="titre" value="<?= htmlspecialchars($request['titre']) ?>" required>
    </div>

    <div>
        <label class="form-label" for="description">Description</label>
        <textarea class="form-textarea" name="description" id="description" required><?= htmlspecialchars($request['description']) ?></textarea>
    </div>

    <div>
        <label class="form-label" for="type_demande">Type</label>
        <select class="form-choix" name="type_demande" id="type_demande" required>
            <option value="échange" <?= $request['type_demande'] === 'échange' ? 'selected' : '' ?>>Échange</option>
            <option value="don" <?= $request['type_demande'] === 'don' ? 'selected' : '' ?>>Don</option>
        </select>
    </div>

    <div>
        <label class="form-label" for="date_besoin">Date de besoin</label>
        <input class="form-input" type="date" name="date_besoin" id="date_besoin" value="<?= htmlspecialchars($request['date_besoin']) ?>" required>
    </div>

    <button class="offer-btn offer-edit" type="submit">Enregistrer les modifications</button>
</form>
</div>