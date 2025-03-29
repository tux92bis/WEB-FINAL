<?php
class OffreStage
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }
    public function offresFiltrees($filtres = []) {
    
        $filtres = array_change_key_case($filtres, CASE_LOWER);
        
        $sql = "SELECT o.*, e.nom as nom_entreprise 
                FROM OffreStage o 
                INNER JOIN Entreprise e ON o.id_entreprise = e.id_entreprise
                WHERE 1=1";
        
        $params = [];
    
    
        if (!empty($filtres['search'])) {
            $sql .= " AND (o.titre LIKE :search OR o.description LIKE :search)";
            $params[':search'] = '%'.$filtres['search'].'%';
        }
    
        if (!empty($filtres['base_remuneration'])) {
            $sql .= " AND o.base_remuneration >= :remuneration";
            $params[':remuneration'] = (float)$filtres['base_remuneration'];
        }
    
 
        if (!empty($filtres['type'])) {
            $sql .= " AND LOWER(o.type) = LOWER(:type)";
            $params[':type'] = $filtres['type'];
        }
    
   
        if (!empty($filtres['domaine']) && is_array($filtres['domaine'])) {
            $placeholders = [];
            foreach ($filtres['domaine'] as $i => $domaine) {
                $key = ":domaine_$i";
                $placeholders[] = $key;
                $params[$key] = $domaine;
            }
            $sql .= " AND o.mineure IN (".implode(',', $placeholders).")";
        }
    
        error_log("Requête SQL : $sql");
        error_log("Paramètres : ".print_r($params, true));
    
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>

