<?php 
//Démarrage de la session et vérification de la connectivité de l'utilisateur
//session_start();
?>
<?php include "../others/header.php";?>

    <body>
        <?php include "../others/navbar.php";?>

        <main>
            <section>
                <div>
                    <h1>Bienvenue chez Fly High</h1>
                    <p>Découvrez le mode à votre rythme</p>
                    
                    <?php if (!isset($_SESSION['Utilisateur_id'])):?>
                        <!--a href="../Auth/connexion.php" class="button">Se connecter</!--a-->
                        <!--a href="../Auth/inscription.php" class="button">S'inscrire</!--a-->
                    <?php else :?> <!--Redirection vers la page d'accueil si l'utilisateur est connecté-->
                        <a href="accueil.php" class="button">Accéder à mon compte</a>
                    <?php endif;?>
                </div>
            </section>
        </main>

        <?php include "../others/footer.php";?>

        <script src="../others/script.js"></script>
    </body>
</html>