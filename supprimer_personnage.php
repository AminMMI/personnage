<?php
require 'dbconnect.php';
require 'Personnage.php';
require 'PersonnageManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $manager = new PersonnageManager($pdo);
    $manager->delete($id); // Supprimer le personnage de la base de données

    // Redirige vers la page principale après suppression
    header('Location: index.php');
    exit();
}
?>
