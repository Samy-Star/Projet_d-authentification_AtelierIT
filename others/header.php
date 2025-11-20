<?php
//Démarrage d'une session si aucune en cours
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Fly High</title>

        <!--Fichier CSS-->
        <link rel="stylesheet" href="../others/design.css">
        <!--Fichier JS-->
        <script src="script.js" defer></script>
    </head>