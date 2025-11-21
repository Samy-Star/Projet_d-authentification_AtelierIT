<?php 
session_start();
include "../Configuration/DB.php";

$errors = [];

//Vérification d'une demande de reinitialiser de la part de l'utilisateur
if (!isset($_SESSION["reset_user_id"])) {
    header("Location: motdepasseoublie.php");
    exit();
}

//Récupération ID Utilisateur
$Utilisateur_id = $_SESSION["reset_user_id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $code_saisi = trim($_POST["code"]);

    if (!preg_match("/^[0-9]{4}$/", $code_saisi)) {
        $errors[] = "Le code doit être exactement 4 chiffres";
    }

    if (empty($errors)) {
        //Récupération du code envoyé à l'utilisateur
        $stmt = $pdo->prepare("
        SELECT reset_code, expires_at
        FROM reinitialisation_MDP 
        WHERE Utilisateur_id = ?
        ORDER BY id DESC LIMIT 1");
        $stmt->execute([$Utilisateur_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            $errors[] = "Aucun vode de réinitialisation trouvé";
        } else {
            $reset_code = $data["reset_code"];
            $expires_at = strtotime($data["expires_at"]);

            if ($expires_at < time()) {
                $errors[] = "Le code a expiré. Veuillez recommencer";
            } else if ($expires_at > time()) {
                if ($code_saisi != $reset_code) {
                    $errors[] = "Code incorrect";
                }
            }
        }

        if (empty($errors)) {
            $_SESSION["reset_verified"] = true;
            header("Location: initialisation_mdp.php");
            exit();
        }
    }
}
?>

<?php include "../others/header.php"; ?>
<?php include "../others/navbar.php"; ?>

<main>
    <section class="form-section">
        <h2>Code de vérification</h2>

        <!--Affichage de erreurs-->
        <?php if (!empty($errors)) : ?>
            <div class="errors">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo htmlspecialchars($errors);?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!--Formulaire de vérification-->
        <form method="POST">
            <label for="code">Code de vérification </label>
            <input type="text" name="code" maxlength="4" required>
            <button type="submit" class="button">Valider</button>
        </form>
    </section>
</main>

<?php include "../others/footer.php"; ?>