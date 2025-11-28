<?php 
session_start();
include "../Configuration/DB.php";

$errors = [];
$succes = "";

//Vérifier que l'utilisateur est bien passé par l'étape du code de récupération
if (!isset($_SESSION["reset_user_id"])) {
    header("Location: motdepasseoublie.php");
    exit();
}

$Utilisateur_id = $_SESSION["reset_user_id"];

//Traitement du formulaire de récupération
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mot_de_passe = trim($_POST["mot_de_passe"]);
    $mot_de_passe2 = trim($_POST["mot_de_passe2"]);

    if (empty($mot_de_passe) || empty($mot_de_passe2)) {
        $errors[] = "Veuillez remplir tous les champs";
    }

    if ($mot_de_passe !== $mot_de_passe2) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }

    if (!preg_match("/^(?=.*[A-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{7,}$/", $mot_de_passe)) {
        $errors[] = "Le mot de passe doit contenir une majuscule, un caractère spécial et au moins 7 caractères";
    }

    if (empty($errors)) {
        $mot_de_passeHash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE Utilisateurs SET mot_de_passe = ? WHERE id = ?");
        if ($stmt->execute([$mot_de_passeHash, $Utilisateur_id])){
            //Nettoyage des variables liées à la session de réinitialisation
            unset($_SESSION["reset_user_id"]);

            //Redirection vers la page de connexion
            $succes = "Votre mot de passe a été réinitialisé avec succès";
            header("Location: connexion.php");
            exit();
        } else {
            $errors[] = "Erreur lors de la mise à jour. Veuillez réessayer";
        }
    }
}
?>

<?php include "../others/header.php"; ?>
<?php include "../others/navbar.php"; ?>

<main>
    <section class="form-section">
        <h2>Nouveau mot de passe</h2>

        <!--Affichage de erreurs-->
        <?php if (!empty($errors)) : ?>
            <div class="errors">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo htmlspecialchars($error);?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!--Formulaire de réinitialisation-->
        <form method="POST">
            <label for="mot_de_passe">Nouveau mot de passe</label>
            <input type="password" name="mot_de_passe"required>

            <label for="mot_de_passe2">Confirmer le nouveau mot de passe</label>
            <input type="password" name="mot_de_passe2"required>

            <button type="submit" class="button">Confirmer</button>
        </form>
    </section>
</main>

<?php include "../others/footer.php"; ?>