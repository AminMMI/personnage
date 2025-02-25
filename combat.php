<?php
session_start();
require_once 'dbconnect.php';
require_once 'personnage.php';
require_once 'PersonnageManager.php';

$manager = new PersonnageManager($pdo);

// Vérification des personnages sélectionnés
if (!isset($_SESSION['joueur1'], $_SESSION['joueur2'])) {
    echo "<span style='color:red;'><strong>Erreur :</strong> Les personnages doivent être sélectionnés avant de commencer le combat.</span>";
    exit;
}

// Récupération des personnages depuis la BDD
$joueur1 = $manager->getById($_SESSION['joueur1']);
$joueur2 = $manager->getById($_SESSION['joueur2']);

// Vérification que les personnages existent bien
if (!$joueur1 || !$joueur2) {
    echo "<span style='color:red;'><strong>Erreur :</strong> Personnages introuvables.</span>";
    exit;
}

// Initialisation des PV dans $_SESSION si ce n'est pas déjà fait
if (!isset($_SESSION['pv_joueur1'])) {
    $_SESSION['pv_joueur1'] = $joueur1->getPvMax(); // Récupère le PV max de la BDD
}
if (!isset($_SESSION['pv_joueur2'])) {
    $_SESSION['pv_joueur2'] = $joueur2->getPvMax(); // Récupère le PV max de la BDD
}


// Initialisation du tour si nécessaire
if (!isset($_SESSION['tour'])) {
    $_SESSION['tour'] = 1; // 1 = Joueur 1, 2 = Joueur 2
}

// Gestion des actions du combat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_SESSION['tour'] == 1) {
        $attaquant = &$joueur1;
        $defenseur = &$joueur2;
        $pv_defenseur = &$_SESSION['pv_joueur2'];
    } else {
        $attaquant = &$joueur2;
        $defenseur = &$joueur1;
        $pv_defenseur = &$_SESSION['pv_joueur1'];
    }

    if ($_POST['action'] === 'attaquer') {
        $pv_defenseur -= $attaquant->getAtk();
    }
    if ($_POST['action'] === 'regenerer') {
        $_SESSION['pv_joueur' . $_SESSION['tour']] = min(
            $_SESSION['pv_joueur' . $_SESSION['tour']] + $attaquant->getHeal(),
            $attaquant->getPvMax() // Utilisation du PV max du personnage en BDD
        );
    }
    

    if ($_SESSION['pv_joueur1'] <= 0 || $_SESSION['pv_joueur2'] <= 0) {
        $gagnant = ($_SESSION['pv_joueur1'] > 0) ? $joueur1 : $joueur2;
        echo "<h2>{$gagnant->getName()} a gagné ! 🏆</h2>";
        echo "<a href='formulaire.php'><button>🔄 Retour au formulaire</button></a>";
        session_destroy();
        exit;
    }

    // Changement de tour
    $_SESSION['tour'] = ($_SESSION['tour'] === 1) ? 2 : 1;
}

// Détermination du joueur actif
$joueurActif = ($_SESSION['tour'] == 1) ? $joueur1 : $joueur2;

echo "<h2>⚔️ Combat en cours ⚔️</h2>";
echo "<p><strong>Joueur 1 :</strong> {$joueur1->getName()} | ❤️ PV : {$_SESSION['pv_joueur1']}</p>";
echo "<p><strong>Joueur 2 :</strong> {$joueur2->getName()} | ❤️ PV : {$_SESSION['pv_joueur2']}</p>";
echo "<h3>C'est au tour de <strong>{$joueurActif->getName()}</strong> !</h3>";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

</head>
<body>
<form method="POST">
    <button type="submit" name="action" value="attaquer">🔥 Attaquer</button>
    <button type="submit" name="action" value="regenerer">💚 Se régénérer</button>
</form>

</body>
</html>