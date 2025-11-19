<?php 
session_start();

//Destruction de toutes les données de session
$_SESSION = [];
session_unset();
session_destroy();

//Redirection vers la page d'accueil
header("Location: index.php");
exit();