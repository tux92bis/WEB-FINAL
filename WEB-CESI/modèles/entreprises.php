<?php

class Entreprise {
    private $bdd;
    
    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function avoirParID($id) {
        $stmt = $this->bdd->prepare("SELECT * FROM Entreprise WHERE id_entreprise = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}