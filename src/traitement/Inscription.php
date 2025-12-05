<?php
// 🔒 Désactive l'affichage des erreurs en prod (à activer temporairement en dev si besoin)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once "../bdd/connexion.php"; // Supposé retourner $bdd (objet PDO)

// Vérifier que le formulaire a été envoyé
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Méthode non autorisée.");
}

// Récupérer et nettoyer les données
$pseudo = trim(isset($_POST['pseudo']) ? $_POST['pseudo'] : '');
$email  = filter_var(trim(isset($_POST['email']) ? $_POST['email'] : ''), FILTER_SANITIZE_EMAIL);
$code_pin = filter_var(isset($_POST['code_pin']) ? $_POST['code_pin'] : '', FILTER_VALIDATE_INT);

$errors = [];

// ✅ Validation
if (empty($pseudo) || strlen($pseudo) < 3) {
    $errors[] = "Le pseudo est requis (min. 3 caractères).";
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email invalide.";
}
if ($code_pin === false || $code_pin === null || $code_pin < 1000 || $code_pin > 9999) {
    $errors[] = "Le code PIN doit être un nombre à 4 chiffres.";
}

if (!empty($errors)) {
    // Rediriger avec erreurs (ou afficher sur la même page)
    $_SESSION['errors'] = $errors;
    header('Location: ../../public/Inscription.php');
    exit;
}

try {
    // 🔍 Vérifier si email ou pseudo déjà utilisé
    $stmt = $bdd->prepare("SELECT id_inscrit FROM inscrit WHERE email = :email OR pseudo = :pseudo");
    $stmt->execute(['email' => $email, 'pseudo' => $pseudo]);
    if ($stmt->fetch()) {
        $errors[] = "Cet email ou pseudo est déjà utilisé.";
        $_SESSION['errors'] = $errors;
        header('Location: ../../public/Inscription.php');
        exit;
    }

    // 🔐 Générer un token de confirmation sécurisé
    $token = bin2hex(random_bytes(32));

    // 💾 Insérer l'utilisateur (non activé)
    $sql = "INSERT INTO inscrit (pseudo, email, code_pin, token_confirmation, actif) 
            VALUES (:pseudo, :email, :code_pin, :token, 0)";
    $query = $bdd->prepare($sql);

    $succes = $query->execute([
        'pseudo' => $pseudo,
        'email' => $email,
        'code_pin' => $code_pin,
        'token' => $token
    ]);

    if (!$succes) {
        throw new Exception("Erreur lors de l'insertion.");
    }

    // ✉️ Envoyer l'email de confirmation
    $sujet = "Veuillez confirmer votre inscription à Nuit Info";
    $lien_confirmation = "https://tonsite.com/public/confirmer_inscription.php?token=" . urlencode($token);

    $message_html = "
        <html><body>
        <h2>Bienvenue, $pseudo !</h2>
        <p>Merci de vous être inscrit à <strong>Nuit Info</strong>.</p>
        <p>Veuillez confirmer votre adresse email en cliquant sur le lien ci-dessous :</p>
        <p><a href='$lien_confirmation' style='padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;'>✅ Confirmer mon compte</a></p>
        <p><small>Ce lien expire dans 24h.</small></p>
        <hr>
        <p>Si vous n’avez pas créé ce compte, ignorez cet email.</p>
        </body></html>
    ";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Nuit Info <no-reply@nuitinfo.org>\r\n";
    // ⚠️ `mail()` peut ne pas fonctionner en local ou sur certains hébergeurs.

    if (mail($email, $sujet, $message_html, $headers)) {
        $_SESSION['success'] = "Un email de confirmation a été envoyé à $email.";
        header('Location: ../../public/Connexion.php');
    } else {
        // Option : enregistrer dans logs, ou utiliser PHPMailer
        $_SESSION['warning'] = "Compte créé, mais échec d’envoi de l’email. Contactez le support.";
        header('Location: ../../public/Connexion.php');
    }

} catch (Exception $e) {
    error_log("Erreur inscription : " . $e->getMessage());
    $_SESSION['errors'] = ["Une erreur interne est survenue. Veuillez réessayer plus tard."];
    header('Location: ../../public/Inscription.php');
    exit;
}