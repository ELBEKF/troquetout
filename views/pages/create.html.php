

<h2>Faire une demande</h2>
<form method="POST" action="create.php">
    <label>Titre:</label><br>
    <input type="text" name="titre" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Type:</label><br>
    <select name="type_demande" required>
        <option value="prêt">Prêt</option>
        <option value="don">Don</option>
        <option value="location">Location</option>
    </select><br><br>

    <label>Date de besoin:</label><br>
    <input type="date" name="date_besoin" required><br><br>

    <button type="submit">Envoyer</button>
</form>
