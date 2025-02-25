<?php
require 'dbconnect.php';  // Fichier de connexion à la base de données
require 'Personnage.php';  // Classe Personnage
require 'PersonnageManager.php';  // Classe PersonnageManager

$manager = new PersonnageManager($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $atk = $_POST['atk'];
    $pvMax = $_POST['pv']; // 🔥 Utiliser pv comme pvMax
    $heal = $_POST['heal'];

    $newPersonnage = new Personnage([
        'name' => $name,
        'pvMax' => $pvMax, // ✅ Ajout de pvMax
        'pv' => $pvMax, // ✅ Le perso commence avec ses PV max
        'atk' => $atk,
        'heal' => $heal
    ]);

    $manager->add($newPersonnage);
    echo "Personnage ajouté avec succès !";
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}



// Récupérer tous les personnages pour les afficher
$personnages = $manager->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Personnage</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

</head>
<body>

<nav>
    <a href="index.php"><section>Gestion des personnages</section></a>
    <a href="formulaire.php"><section>Formulaire</section></a>
</nav>


    <!-- Formulaire pour ajouter un personnage -->
     <main>
     <h2>Ajouter un Nouveau Personnage</h2>

        <form action="" method="POST">
        <label for="name">Nom du personnage :</label>
        <input type="text" id="name" name="name" required>

        <label for="pv">Points de vie :</label>
        <input type="number" id="pv" name="pv" required>

        <label for="atk">Points d'attaque :</label>
        <input type="number" id="atk" name="atk" required>

        <label for="heal">Valeur de régénération :</label>
        <input type="number" id="heal" name="heal" required>

        <button type="submit" name="add">Ajouter le personnage</button>
</form>


        <h2>Liste des Personnages</h2>

        <table border="1">
            <tr>
                <th>Nom</th>
                <th>Attaque</th>
                <th>PV</th>
                <th>Heal</th>
                <th>Actions</th> <!-- Nouvelle colonne pour les actions -->
            </tr>
            <?php foreach ($personnages as $personnage) : ?>
                <tr>
                    <td><?= $personnage->getName() ?></td>
                    <td><?= $personnage->getAtk() ?></td>
                    <td><?= $personnage->getPv() ?></td>
                    <td><?= $personnage->getHeal() ?></td>
                    <td>
                        <!-- Formulaire de suppression avec un bouton -->
                        <form method="POST" action="supprimer_personnage.php">
                            <input type="hidden" name="id" value="<?= $personnage->getId() ?>" />
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce personnage ?');">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>


        <h2>Accès à la zone de combat : <a href="formulaire.php">cliquez ici</a></h2>
    </main>
</body>
</html>
