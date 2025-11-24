<?php
session_start();

//Vérification de la connectivité de l'utilisateur
if (!isset($_SESSION["Utilisateur_id"])) {
    header("Location: ../Auth/connexion.php");
    exit();
}

//Récupération des informations de l'utilisateur
$nom = $_SESSION["Utilisateur_nom"];
$prenoms = $_SESSION["Utilisateur_prenoms"];
?>

<?php include "../others/header.php"; ?>
<?php include "../others/navbar.php"; ?>

<main>
    <section class="welcome-section">
        <h2><b>Bienvenue <i><?php echo htmlspecialchars($prenoms. " " .$nom);?> 😄🎉</i></b></h2>

        <!--a href="deconnexion.php" class="button logout-btn">Se déconnecter</!--a-->
    </section>
</main>

<?php include "../others/footer.php"; ?>