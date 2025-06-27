<h2>Modifier votre demande</h2>

<form method="post">
    <div>
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" value="<?= htmlspecialchars($request['titre']) ?>" required>
    </div>

    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description" required><?= htmlspecialchars($request['description']) ?></textarea>
    </div>

    <div>
        <label for="type_demande">Type</label>
        <select name="type_demande" id="type_demande" required>
            <option value="échange" <?= $request['type_demande'] === 'échange' ? 'selected' : '' ?>>Échange</option>
            <option value="don" <?= $request['type_demande'] === 'don' ? 'selected' : '' ?>>Don</option>
        </select>
    </div>

    <div>
        <label for="date_besoin">Date de besoin</label>
        <input type="date" name="date_besoin" id="date_besoin" value="<?= htmlspecialchars($request['date_besoin']) ?>" required>
    </div>

    <button type="submit">Enregistrer les modifications</button>
</form>
