<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Nuit Info</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Messages d'erreur et de succès */
        .error {
            color: #ff4d4d;
            background: rgba(255, 204, 204, 0.8);
            padding: 12px;
            margin: 15px auto;
            border-radius: 6px;
            font-weight: bold;
            max-width: 400px;
            text-align: center;
        }
        .success {
            color: #4CAF50;
            background: rgba(204, 255, 204, 0.8);
            padding: 12px;
            margin: 15px auto;
            border-radius: 6px;
            font-weight: bold;
            max-width: 400px;
            text-align: center;
        }

        /* Fond sombre comme dans l'image */
        body {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            color: white;
        }

        form {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            text-align: center;
        }

        .form-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .form-title::before {
            content: "📄";
            font-size: 1.3rem;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: 600;
            color: #333;
            text-align: left;
            font-size: 15px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
        }

        .login-link {
            display: block;
            margin: 20px 0 15px;
            color: #2196F3;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        input[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<form method="POST" action="login.php">
    <h2 class="form-title">Inscription</h2>

    <label>Pseudo :</label>
    <input type="text" name="pseudo" required minlength="3" maxlength="50">

    <label>Email :</label>
    <input type="email" name="email" required>

    <label>Code PIN (4 chiffres) :</label>
    <input type="text" name="code_pin" pattern="[0-9]{4}" title="4 chiffres requis" required>

    <a href="login.php" class="login-link">Déjà inscrit ? Connectez-vous</a>

    <input type="submit" value="S'inscrire">
</form>

</body>
</html>