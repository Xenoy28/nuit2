<?php
global $bdd;
session_start();

// 🔌 CORRECTION PRINCIPALE : Inclure la connexion à la BDD AVANT toute utilisation de $bdd
require_once "../bdd/connexion.php"; // Ce fichier DOIT exister et définir $bdd

// 🛑 Vérifier que la requête est bien en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "⚠️ Requête invalide.";
    header('Location: ../public/Inscription.php');
    exit;
}

// 📥 Récupérer les données du formulaire
$pseudo   = isset($_POST['pseudo']) ? trim($_POST['pseudo']) : '';
$email    = isset($_POST['email']) ? trim($_POST['email']) : '';
$code_pin = isset($_POST['code_pin']) ? $_POST['code_pin'] : '';

// 📋 Tableau d’erreurs
$errors = [];

// ✅ Validation du pseudo
if ($pseudo === '' || strlen($pseudo) < 2 || strlen($pseudo) > 50) {
    $errors[] = "Le pseudo est requis (2 à 50 caractères).";
}

// ✅ Validation de l'email
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L’adresse email est invalide.";
}

// ✅ Validation du code PIN (4 chiffres exactement)
if (!ctype_digit($code_pin) || strlen($code_pin) !== 4) {
    $errors[] = "Le code PIN doit contenir exactement 4 chiffres.";
}

// 🔍 Vérification des doublons (si pas d’erreur déjà)
if (empty($errors)) {
    try {
        $stmt = $bdd->prepare("SELECT id_inscrit FROM inscrit WHERE email = ? OR pseudo = ?");
        $stmt->execute([$email, $pseudo]);
        if ($stmt->fetch()) {
            $errors[] = "Cet email ou ce pseudo est déjà utilisé.";
        }
    } catch (PDOException $e) {
        error_log("Erreur BDD (doublon) : " . $e->getMessage());
        $errors[] = "Erreur temporaire. Veuillez réessayer plus tard.";
    }
}

// ❌ Si erreurs → retour au formulaire
if (!empty($errors)) {
    $_SESSION['error'] = implode(" ", $errors);
    header('Location: ../public/Inscription.php');
    exit;
}

// 💾 Insertion dans la base de données
try {
    $stmt = $bdd->prepare("INSERT INTO inscrit (pseudo, email, code_pin) VALUES (?, ?, ?)");
    $success = $stmt->execute([$pseudo, $email, (int)$code_pin]);

    if (!$success) {
        throw new Exception("Échec de l’insertion.");
    }

} catch (Exception $e) {
    error_log("Erreur insertion BDD : " . $e->getMessage());
    $_SESSION['error'] = "❌ L’inscription a échoué. Veuillez réessayer.";
    header('Location: ../public/Inscription.php');
    exit;
}

// ✉️ Envoi de l’email de confirmation (texte brut)
$sujet = "✅ Inscription réussie - Nuit Info";
$message = "Bonjour $pseudo,\n\n"
    . "Votre inscription est confirmée !\n"
    . "📧 Email : $email\n"
    . "🔢 Code PIN : $code_pin\n\n"
    . "Conservez bien ces informations — elles vous serviront à vous connecter.\n\n"
    . "Merci de participer à Nuit Info !\n"
    . "— L’équipe";

$headers = "From: no-reply@nuitinfo.org\r\n"
    . "Reply-To: contact@nuitinfo.org\r\n"
    . "Content-Type: text/plain; charset=UTF-8";

// Tentative d’envoi
$envoye = mail($email, $sujet, $message, $headers);

// ✅ Redirection avec message
if ($envoye) {
    $_SESSION['success'] = "✅ Inscription réussie ! Un email de confirmation a été envoyé à $email.";
} else {
    $_SESSION['success'] = "✅ Inscription réussie. (L’email n’a pas pu être envoyé — configuration serveur probablement manquante.)";
    // ⚠️ Normal en local avec XAMPP/WAMP sans MailHog/SMTP
}

header('Location: ../public/login.php');
exit;