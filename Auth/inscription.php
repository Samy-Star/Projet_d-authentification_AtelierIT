<?php 
session_start();

//Inclusion du fichier de connexion à la base de données
include "../Configuration/DB.php";

//
$errors = [];
$succes = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Récupération et sécurisation des données envoyées par le formulaire
    $nom = trim($_POST['nom']);
    $prenoms = trim($_POST['prenoms']);
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mdp']);

    //Vérification du remplissage des champ
    if (empty($nom) || empty($prenoms) || empty($email)) {
        $errors [] = "Veuillez remplir ces champs";
    }

    //Vérification de la validité de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors [] = "Adresse email invalide";
    }

    //Vérification de la validité du mot de passe
    if (!preg_match("/^(?=.*[A-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{7,}$/", $mot_de_passe)) {
        $errors [] = "Mot de passe invalide. Il doit contenir au moins une majuscule, un caractère spécial et avoir au moins 7 caractères";
    }

    //Vérifier si l'email n'existe pas déjà dans la base de données
    $stmt = $pdo->prepare("SELECT id FROM UTILISATEURS WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $errors [] = "Email déjà utilisé. Veuillez entrer un autre email";
    }

    if (empty($errors)) {
        //Hashage du mot de passe
        $mot_de_passeHash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO Utilisateurs(nom, prenoms, email, mot_de_passe) VALUES (?, ?, ?, ?)");
        if($stmt->execute([$nom, $prenoms, $email, $mot_de_passeHash])) {
            $Utilisateur_id = $pdo->lastInsertId();
            
            //Connexion automatique de l'utilisateur
            $_SESSION["Utilisateur_id"] = $Utilisateur_id;
            $_SESSION["Utilisateur_nom"] = $nom;
            $_SESSION["Utilisateur_prenoms"] = $prenoms;
            $_SESSION["Utilisateur_email"] = $email;

            //Redirection vers la page d'accueil
            header("Location: ../Principaux/accueil.php");
            exit();
        } else {
            $errors [] = "Une erreur est survenue, veuillez réessayer plus tard";
        }
    }

}
?>

<?php include "../others/header.php"; ?>
<?php include "../others/navbar.php"; ?>

<main>
    <section class="form-section">
        <h2>Inscription</h2>

        <!--Messages en cas d'erreurs-->
        <?php if (!empty($errors)) : ?>
            <div class="errors">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo htmlspecialchars($error);?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!--Messages de succes-->
        <?php if (!empty($succes)) : ?>
            <div class="success">
                <p><?php echo htmlspecialchars($succes); ?></p>
            </div>
        <?php endif; ?>

        <!--Formulaire d'inscription-->
        <form id="registerForm" method="POST" action="">
            <label for="nom">Nom</label>
            <input type="text" name="nom" required>

            <label for="prenom">Prenoms</label>
            <input type="text" name="prenoms" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" name="mot_de_passe" required>

            <button type="submit" class="button">S'inscrire</button>
        </form>
    </section>
</main>

<?php include "../others/footer.php"; ?>