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
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            $errors[] = "Il n'existe aucun compte avec cet email";
        } else {
            $_SESSION["reset_user_id"] = $user["id"];
            //Redirection vers la page de reinitialisation du mot de passe
            header("Location: initialisation_mdp.php");
            exit();
        }
    }
}
?>

<?php include "../others/header.php";?>
<?php include "../others/navbar.php";?>

<main>
    <section class="form-section">
        <h2>Mot de passe oublié</h2>

        <?php if (!empty($errors)) : ?>
            <div class="errors">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo htmlspecialchars($error);?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($succes)) : ?>
            <div class="succes">
                <?php echo htmlspecialchars($succes);?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label for="email">Entrez votre email</label>
            <input type="email" name="email" required>

            <button type="submit" class="button">Valider</button>
        </form>
    </section>
</main>

<?php include "../others/footer.php";?>