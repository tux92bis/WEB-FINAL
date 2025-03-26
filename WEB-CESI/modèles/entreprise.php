<?php
class Entreprise {
    private $bdd;
    
    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function avoirToutesEntreprises() {
        $stmt = $this->bdd->prepare("SELECT * FROM Entreprise");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function avoirEntreprisesFiltrees($filtres) {
        $sql = "SELECT * FROM Entreprise WHERE 1=1";
        $params = [];
        
        if (!empty($filtres['secteur'])) {
            $sql .= " AND secteur = :secteur";
            $params[':secteur'] = $filtres['secteur'];
        }
        
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}