<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Nuit Info</title>
    <style>
        .error { color: red; background: #ffe6e6; padding: 10px; margin: 10px 0; }
        .success { color: green; background: #e6ffe6; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
<h1>📝 Inscription</h1>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<form method="POST" action="../traitements/inscription_traitement.php">
    <label>Pseudo :<br>
        <input type="text" name="pseudo" required minlength="3" maxlength="50">
    </label><br><br>

    <label>Email :<br>
        <input type="email" name="email" required>
    </label><br><br>

    <label>Code PIN (4 chiffres) :<br>
        <input type="text" name="code_pin" pattern="[0-9]{4}" title="4 chiffres requis" required>
    </label><br><br>

    <button type="submit">S’inscrire</button>
</form>

<p><a href="Connexion.php">Déjà inscrit ? Connectez-vous</a></p>
</body>
</html>