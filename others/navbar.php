<?php
//Démarrage d'une session si aucune en cours
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar">
    <div>
        <img src="">
        <span>Fly High</span>
    </div>

    <div class="nav-links">
        <?php if (!isset($_SESSION["Utilisateur_id"])) : ?> 
            <!--Si l'utilisateur n'est pas connecter-->
            <a href="../Auth/connexion.php">Se connecter</a> <!--Bouton de connexion-->
            <a href="../Auth/inscription.php">S'inscrire</a> <!--Bouton d'inscription-->
        <?php else :?>
            <!--Si l'utilisateur est connecté-->
            <a href="../accueil.php">Mon espace</a>
            <a href="../Principaux/deconnexion.php">Se deconnecter</a> <!--Bouton de déconnexion-->
        <?php endif; ?>
    </div>
</nav>