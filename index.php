<?php 
//Démarrage de la session et vérification de la connectivité de l'utilisateur
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Agence de voyage - Accueil</title>
        <link rel="stylesheet" href="design.css">
    </head>

    <body>
        <?php include "navbar.php";?>

        <main>
            <section>
                <div>
                    <h1>Bienvenue chez Fly High</h1>
                    <p>Découvrez le mode à votre rythme</p>
                    <?php if (!isset($_SESSION['user_id'])):?>
                        <a href="login.php" class="button">Se connecter</a>
                        <a href="register.php" class="button">S'inscrire</a>
                    <?php else :?>
                        <a href="accueil.php" class="button">Accéder à mon compte</a>
                    <?php endif;?>
                </div>
            </section>
        </main>

        <?php include "footer.php";?>

        <script src="script.js"></script>
    </body>
</html>
