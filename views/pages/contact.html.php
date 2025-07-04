<h1><?= htmlspecialchars($title) ?></h1>

<?php if (!empty($_SESSION['contact_success'])): ?>
    <p style="color: green;"><?= htmlspecialchars($_SESSION['contact_success']) ?></p>
    <?php unset($_SESSION['contact_success']); ?>
<?php endif; ?>

<form action="sendContact.php" method="POST">
    <label>Nom :</label><br>
    <input type="text" name="nom" required><br><br>

    <label>Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label>Message :</label><br>
    <textarea name="message" rows="5" required></textarea><br><br>

    <button type="submit">Envoyer</button>
</form>
