<?php
session_start();
include "../Configuration/DB.php";

$errors = [];
$succes = "";

//Après soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email non valide";
    }

    if (empty($errors)) {
        //Vérification de l'existence de l'email dans la base
        $stmt = $pdo->prepare("SELECT id FROM Utilisateurs WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() === 0) {
            $errors[] = "Il n'existe aucun compte avec cet email";
        } else {
            //Génération du code de récupération
            $code = random_int(1000, 9999);

            //Durée de vie du code
            $expiration = date("Y-m-d H:i:s", time() + 300);

            //Stockage dans la base de données
            $update = $pdo->prepare("UPDATE Utilisateurs SET reset_code = ? WHERE email = ?");
            $update->execute([$email, $code, $expiration]);

            $_SESSION["email_recup"] = $email;

            //Envoi du mail de récupération
            mail($email, "Code de récupération", "Votre code : $code");
            $succes = "Un code de vérification a été envoyé à votre email. Veuillez vérifier votre boite mail";

            //Redirection vers la page de vérification du code
            header("Location: processioncode.php");
            exit();
        }
    }
}