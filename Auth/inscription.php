<?php 
session_start();

//Inclusion du fichier de connexion à la base de données
include "../Configuration/DB.php";

//
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == $_POST) {
    //Récupération et sécurisation des données envoyées par le formulaire
    $nom = trim($_POST['nom']);
    $prenoms = trim($_POST['prenoms']);
    $email = trim($_POST['email']);
    $mdp = trim($_POST['mdp']);

    //Vérification du remplissage des champ
    if (empty($nom) || empty($prenoms) || empty($email)) {
        $errors [] = "Veuillez remplir ces champs";
    }

    //Vérification de la validité de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors [] = "Adresse email invalide";
    }

    //Vérification de la validité du mot de passe
    if (!preg_match("/^(?=.[A-Z)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{7,}$/", $mdp)) {
        $errors [] = "Mot de passe invalide. Il doit contenir au moins une majuscule, un caractère spécial et avoir au moins 7 caractères";
    }

    //Vérifier si l'email n'existe pas déjà dans la base de données
    $stmt = $pdo->prepare("SELECT id FROM UTILISATEURS WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $errors [] = "Email déjà utilisé. Veuillez entrer un autre email";
    }

    if (empty($errors)) {
        
    }

}