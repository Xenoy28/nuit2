<?php
// bdd/connexion.php
try {
    $bdd = new PDO("mysql:host=localhost;dbname=nuit_info;charset=utf8", "root", "");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
}
?>

