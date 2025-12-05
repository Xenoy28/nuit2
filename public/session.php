<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
<h2>Connexion</h2>

<?php
if (isset($_SESSION['error'])) {
    echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
?>
<form method="POST" action="../src/traitement/traitement.php">
    <div>
        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required>
    </div>
    <div>
        <label for="code_pin">Code PIN :</label>
        <input type="password" id="code_pin" name="code_pin" required>
    </div>
    <button type="submit">Se connecter</button>
</form>
</body>
</html>