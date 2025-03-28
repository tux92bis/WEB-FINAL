<?php
class OffreStage {
    private $bdd;
    
    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function offresFiltrees($filtres) {
        $sql = "SELECT o.*, 
                (SELECT COUNT(*) FROM Favoris f WHERE f.id_offre = o.id_offre AND f.id_etudiant = :user_id) as est_favori
                FROM OffreStage o WHERE 1=1";
        $params = [':user_id' => $_SESSION['utilisateur']['id']];
        
        if (!empty($filtres['search'])) {
            $sql .= " AND (o.titre LIKE :search OR o.description LIKE :search)";
            $params[':search'] = "%{$filtres['search']}%";
        }
        
        if (!empty($filtres['type'])) {
            $sql .= " AND o.type = :type";
            $params[':type'] = $filtres['type'];
        }
        
        if (!empty($filtres['remuneration'])) {
            $sql .= " AND o.base_remuneration >= :remuneration";
            $params[':remuneration'] = $filtres['remuneration'];
        }
        
        if (!empty($filtres['domaine'])) {
            $sql .= " AND o.mineure IN (" . implode(',', array_fill(0, count($filtres['domaine']), '?')) . ")";
            $params = array_merge($params, $filtres['domaine']);
        }

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}