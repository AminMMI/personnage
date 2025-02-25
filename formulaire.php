<?php
session_start();
require_once 'dbconnect.php';
require_once 'PersonnageManager.php';

$manager = new PersonnageManager($pdo);
$personnages = $manager->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['joueur1']) && isset($_POST['joueur2'])) {
        $_SESSION['joueur1'] = $_POST['joueur1'];
        $_SESSION['joueur2'] = $_POST['joueur2'];

        // Vérifier si les personnages sont identiques
        if ($_SESSION['joueur1'] === $_SESSION['joueur2']) {
            echo "<span style='color:red;'><strong>Erreur :</strong> Vous ne pouvez pas combattre avec le même personnage !</span> <a href='formulaire.php'><button>🔄 Retour au formulaire</button></a>";
            session_destroy();
            exit;
        }

        // Redirection vers le combat
        header("Location: combat.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix des personnages</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

</head>
<body>
    
<nav>
    <a href="index.php"><section>Gestion des personnages</section></a>
    <a href="formulaire.php"><section>Formulaire</section></a>
</nav>

<form method="POST" class="choix">
    <label for="joueur1">Sélectionnez le Joueur 1 :</label>
    <select name="joueur1" required>
        <?php foreach ($personnages as $perso) : ?>
            <option value="<?= $perso->getId() ?>"><?= $perso->getName() ?></option>
        <?php endforeach; ?>
    </select>

    <label for="joueur2">Sélectionnez le Joueur 2 :</label>
    <select name="joueur2" required>
        <?php foreach ($personnages as $perso) : ?>
            <option value="<?= $perso->getId() ?>"><?= $perso->getName() ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Lancer le Combat</button>
</form>
</body>
</html>