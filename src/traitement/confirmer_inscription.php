<?php
session_start();
require_once "../bdd/connexion.php";

$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!$token) {
    $_SESSION['errors'] = ["Lien de confirmation invalide."];
    header('Location: Connexion.php');
    exit;
}

try {
    // Rechercher un utilisateur avec ce token non confirmé
    $stmt = $bdd->prepare("SELECT id_inscrit, pseudo, email FROM inscrit WHERE token_confirmation = ? AND actif = 0");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['errors'] = ["Ce lien a expiré ou le compte est déjà activé."];
        header('Location: Connexion.php');
        exit;
    }

    // ✅ Activer le compte
    $update = $bdd->prepare("UPDATE inscrit SET actif = 1, token_confirmation = NULL WHERE id_inscrit = ?");
    $update->execute([$user['id_inscrit']]);

    $_SESSION['success'] = "🎉 Bonjour " . htmlspecialchars($user['pseudo']) . ", votre compte est maintenant activé ! Vous pouvez vous connecter.";
    header('Location: Connexion.php');

} catch (Exception $e) {
    error_log("Erreur activation : " . $e->getMessage());
    $_SESSION['errors'] = ["Erreur lors de la confirmation. Veuillez réessayer."];
    header('Location: Connexion.php');
}