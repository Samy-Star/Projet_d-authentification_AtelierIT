<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=Auth_DB", "root", "@Always_and_Forever160122");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur" . $e->getMessage();
}
?>