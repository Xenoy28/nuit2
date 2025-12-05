<?php
$bdd = null;
session_start();
require_once '../bdd/connexion.php';
$max_attempts = 5;
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (isset($_POST['pseudo'], $_POST['code_pin'])) {
    $pseudo = trim($_POST['pseudo']);
    $code_pin = trim($_POST['code_pin']);
    if (empty($pseudo) || empty($code_pin) || strlen($pseudo) > 50 || strlen($code_pin) != 4 || !ctype_digit($code_pin)) {
        header("Location: ../../public/Connexion.php?error=1");
        exit();
    } elseif ($_SESSION['login_attempts'] >= $max_attempts) {
        header("Location: ../../public/Connexion.php?error=1");
        exit();
    } else {
        try {
            $sql = "SELECT id, pseudo, code_pin FROM inscrit WHERE pseudo = :pseudo";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([':pseudo' => $pseudo]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($code_pin, $user['code_pin'])) {
                $_SESSION['login_attempts'] = 0;
                $_SESSION['user'] = $user;
                $_SESSION['pseudo'] = $user['pseudo'];
                header("Location: index.php");
                exit();
            } else {
                // Échec : incrémenter les tentatives
                $_SESSION['login_attempts']++;
                header("Location: ../../public/Connexion.php?error=1");
                exit();
            }
        } catch (PDOException $e) {
            error_log("Erreur BDD : " . $e->getMessage());
            header("Location: ../../public/Connexion.php?error=1");
            exit();
        }
    }
} else {
    header("Location: ../../public/Connexion.php");
    exit();
}
?>