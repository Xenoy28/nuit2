<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=nuit_info', 'Nuit', 'Tableronde');
}catch (Exception $e){
    echo 'Erreur : '.$e->getMessage();
}
