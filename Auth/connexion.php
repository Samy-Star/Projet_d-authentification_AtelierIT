<?php
session_start();

//Inclusion du fichier de connexion à la base de données
include "../Configuration/DB.php";

//
$errors = [];
$succes = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Récupération et sécurisation des données envoyées par le formulaire
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    //Vérification du remplissage des champs
    if (empty($email) || empty($mot_de_passe)) {
        $errors [] = "Veuillez remplir ces champs";
    }

    //Vérification de la validité de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors [] = "Adresse email invalide";
    }

    if (empty($errors)) {
        //Vérification de l'existence de l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $Utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($Utilisateur) {
            //Vérification du mot de passe
            if (password_verify($mot_de_passe, $Utilisateur["mot_de_passe"])) {
                //Connexion
                $_SESSION["Utilisateur_id"] = $Utilisateur["id"];
                $_SESSION["Utilisateur_nom"] = $Utilisateur["nom"];
                $_SESSION["Utilisateur_prenoms"] = $Utilisateur["prenoms"];
                $_SESSION["Utilisateur_email"] = $Utilisateur["email"];

                //Redirection vers la page d'accueil
                header("Location: ../Principaux/accueil.php");
                exit();
            } else {
                $errors [] = "Mot de passe incorrect";
            }
        } else {
            $errors [] = "Cet email ne correspond à aucun compte";
        }
    }
}
?>

<?php include "../others/header.php";?>
<?php include "../others/navbar.php";?>

<main>
    <section class="form-selection">
        <h2>Connexion</h2>

        <?php if (!empty($errors)) : ?>
            <div class="errors">
                <?php foreach ($errors as $error) : ?>
                    <p><?=htmlspecialchars($error)?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Mot de passe</label>
            <input type="mot_de_passe" name="mot_de_passe" required>

            <button type="submit" class="button">Se connecter</button>

            <p>
                <a href="motdepasseoublie.php">Mot de passe oublié</a>
            </p>

            <p class="info">Pas encore de compte ?
                <a href="inscription.php">S'inscrire</a>
            </p>
        </form>
    </section>
</main>

<?php include "../others/footer.php"?>