<?php
require_once 'personnage.php';

class PersonnageManager {
    private $pdo;

    // Constructeur qui reçoit la connexion PDO à la base de données
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    
    // Méthode pour ajouter un personnage à la base de données
    public function add(Personnage $personnage) {
        $sql = "INSERT INTO personnage (name, atk, pv, pvMax, heal) VALUES (:name, :atk, :pv, :pvMax, :heal)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $personnage->getName());
        $stmt->bindValue(':atk', $personnage->getAtk());
        $stmt->bindValue(':pv', $personnage->getPv());
        $stmt->bindValue(':pvMax', $personnage->getPvMax());
        $stmt->bindValue(':heal', $personnage->getHeal());
        $stmt->execute();
    }

    // Méthode pour récupérer un personnage par son ID
    public function getById($id) {
        $query = $this->pdo->prepare("SELECT * FROM personnage WHERE id = :id");
        $query->execute(['id' => $id]);
        $data = $query->fetch(PDO::FETCH_ASSOC);
    
        if ($data) {
            return new Personnage($data);
        }
        return null;
    }
    
    

    // Méthode pour récupérer tous les personnages
    // Corrige la méthode getAll pour retourner tous les personnages
public function getAll() {
    $query = $this->pdo->prepare('SELECT * FROM personnage');
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $personnages = [];
    foreach ($result as $data) {
        $personnages[] = new Personnage([
            'id' => $data['id'],
            'name' => $data['name'],
            'atk' => $data['atk'],
            'pv' => $data['pv'],
            'heal' => $data['heal']
        ]);
    }

    return $personnages;  // Retourne le tableau complet
}


    // Méthode pour mettre à jour un personnage
    public function update(Personnage $personnage) {
        $query = $this->pdo->prepare('UPDATE personnage SET pv = :pv, heal = :heal WHERE id = :id');
        $query->bindValue(':pv', $personnage->getPv());
        $query->bindValue(':heal', $personnage->getHeal()); // Ajout de la mise à jour du heal
        $query->bindValue(':id', $personnage->getId());
        $query->execute();
    }
    
    public function updatePv($personnage) {
        $query = $this->pdo->prepare("UPDATE personnage SET pv = :pv WHERE id = :id");
        $query->execute([
            'id' => $personnage->getId()
        ]);
    }
    
    

    // Méthode pour supprimer un personnage
    public function delete($id) {
        $sql = "DELETE FROM personnage WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

 
    // fonction pour heal
    public function getHealById($id) {
        $query = $this->pdo->prepare("SELECT heal FROM personnage WHERE id = :id");
        $query->execute(['id' => $id]);
        $data = $query->fetch(PDO::FETCH_ASSOC);
    
        return $data ? $data['heal'] : null;
    }
    
    // Fonction pour retrouver les pv d'origines 

    public function getPvMaxById(int $id): ?Personnage {
        $query = $this->pdo->prepare("SELECT * FROM personnage WHERE id = :id");
        $query->execute(['id' => $id]);
        $data = $query->fetch(PDO::FETCH_ASSOC);
    
        if ($data) {
            return new Personnage($data); // `pvMax` sera hydraté via `hydrate()`
        }
        return null;
    }
    
    
}
?>
