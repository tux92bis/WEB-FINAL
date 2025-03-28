<?php
class OffreStage
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }
    public function offresFiltrees($filtres = []) {
        $sql = "SELECT o.*, 
                o.debut as date_de_debut,
                o.fin as date_de_fin,
                o.type
                FROM OffreStage o 
                WHERE 1=1";
        
        $params = [];
        
        // Correction des filtres
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
        
        if (!empty($filtres['domaine']) && is_array($filtres['domaine'])) {
            $placeholders = str_repeat('?,', count($filtres['domaine']) - 1) . '?';
            $sql .= " AND o.mineure IN ($placeholders)";
            $params = array_merge($params, $filtres['domaine']);
        }
    
        try {
            $stmt = $this->bdd->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
