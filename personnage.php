<?php
class Personnage {
    private int $id;
    private string $name;
    private int $pv;
    private int $atk;
    private int $pvMax;

    private int $heal; 
    public function __construct(array $data) {
        $this->hydrate($data);
    }

    public function hydrate(array $data) {
        if (isset($data['id'])) {
            $this->setId((int) $data['id']);
        }
        if (isset($data['name'])) {
            $this->setName($data['name']);
        }
        if (isset($data['atk'])) {
            $this->setAtk((int) $data['atk']);
        }
        if (isset($data['heal'])) {
            $this->setHeal((int) $data['heal']);
        } 
        if (isset($data['pv'])) {
            $this->setPv((int) $data['pv']);
        }
        if (isset($data['pvMax'])) {
            $this->setPvMax((int) $data['pvMax']); 
        }
    }
    
    
    
    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPv() {
        return $this->pv;
    }

    public function getAtk() {
        return $this->atk;
    }

    public function getHeal() { 
        return $this->heal; 
    }

    // Setters
    public function setId(int $id) {
        $this->id = $id;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function setPv(int $pv) {
        $this->pv = max(0, $pv); 
    }

    public function setAtk(int $atk) {
        $this->atk = max(0, $atk);
    }

    public function setHeal(int $heal) {
        $this->heal = max(0, $heal);
    }

    // fonction heal
    public function heal() {
        $this->setPv($this->pv + $this->heal); // Ajoute directement la valeur de heal aux PV
    }
    
    public function setPvMax(int $pvMax): void {
        $this->pvMax = $pvMax;
    }
    
    public function getPvMax(): int {
        return $this->pvMax;
    }
}
    


?>
