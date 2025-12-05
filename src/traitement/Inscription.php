<?php
$bdd = null;
var_dump($_POST);
require_once "../bdd/connexion.php";

isset($_POST["envoye"]);
$sql="INSERT INTO inscrit(pseudo, email, code_pin) VALUES (:pseudo, :email, :code_pin)";
$query = $bdd->prepare($sql);

$pseudo = $_POST['pseudo'];
$email = $_POST['email'];
$code_pin = $_POST['code_pin'];

$query->execute(['pseudo'=> $pseudo,'email'=> $email,'code_pin'=> $code_pin]);
header('Location: ../../public/Connexion.php');








