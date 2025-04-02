<?php
class OffreStage
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function creerOffre($data)
    {
        $sql = "INSERT INTO OffreStage (titre, description, date_debut, date_fin, type, base_remuneration, id_entreprise, id_pilote, id_admin) 
                VALUES (:titre, :description, :date_debut, :date_fin, :type, :base_remuneration, :id_entreprise, :id_pilote, :id_admin)";
        
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            ':titre' => $data['titre'],
            ':description' => $data['description'],
            ':date_debut' => $data['date_debut'] ?? null,
            ':date_fin' => $data['date_fin'] ?? null,
            ':type' => $data['type'],
            ':base_remuneration' => $data['base_remuneration'],
            ':id_entreprise' => $data['id_entreprise'],
            ':id_pilote' => $data['id_pilote'],
            ':id_admin' => $data['id_admin']
        ]);
        
        return $this->bdd->lastInsertId();
    }

    public function offresFiltrees($filtres = [])
    {

        $filtres = array_change_key_case($filtres, CASE_LOWER);

        $sql = "SELECT o.*, e.nom as nom_entreprise 
                FROM OffreStage o 
                INNER JOIN Entreprise e ON o.id_entreprise = e.id_entreprise
                WHERE 1=1";

        $params = [];


        if (!empty($filtres['search'])) {
            $sql .= " AND (o.titre LIKE :search OR o.description LIKE :search)";
            $params[':search'] = '%' . $filtres['search'] . '%';
        }

        if (!empty($filtres['base_remuneration'])) {
            $sql .= " AND o.base_remuneration >= :remuneration";
            $params[':remuneration'] = (float) $filtres['base_remuneration'];
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
            $sql .= " AND o.mineure IN (" . implode(',', $placeholders) . ")";
        }

        error_log("Requête SQL : $sql");
        error_log("Paramètres : " . print_r($params, true));

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function avoirParID($id)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM OffreStage WHERE id_offre = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function supprimerOffre($id_offre) {
        try {
            // Debug: Vérifiez que l'ID est reçu
            error_log("Tentative de suppression de l'offre ID: " . $id_offre);
            
            $stmt = $this->bdd->prepare("DELETE FROM OffreStage WHERE id_offre = ?");
            $result = $stmt->execute([$id_offre]);
            
            // Debug: Vérifiez le résultat
            error_log("Résultat suppression: " . ($result ? "succès" : "échec"));
            error_log("Lignes affectées: " . $stmt->rowCount());
            
            return $result && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur PDO: " . $e->getMessage());
            return false;
        }
    }


}
?>