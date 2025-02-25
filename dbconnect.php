<?php
// Configuration de la connexion à la base de données
$host = 'localhost';   // ou ton hôte si ce n'est pas localhost
$dbname = 'poo_sgbd';    // Remplace par le nom de ta base de données
$username = 'root';    // Nom d'utilisateur pour la base de données
$password = '';        // Mot de passe pour la base de données

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, on affiche un message d'erreur
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}
?>
