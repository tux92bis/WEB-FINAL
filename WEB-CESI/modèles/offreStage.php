<?php
class OffreStage
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }
    public function offresFiltrees($filtres = [])
{
    $sql = "SELECT o.*, 
                   o.date_debut as date_de_debut,
                   o.date_fin as date_de_fin,
                   o.type,
                   e.nom as nom_entreprise,
                   COALESCE((SELECT COUNT(*) FROM Favoris f 
                            WHERE f.id_offre = o.id_offre 
                            AND f.id_etudiant = (
                                SELECT id_etudiant FROM Etudiant 
                                WHERE id_utilisateur = :user_id
                            )), 0) as est_favori
            FROM OffreStage o 
            INNER JOIN Entreprise e ON o.id_entreprise = e.id_entreprise
            WHERE 1 = 1"; 

    $params = [
        ':user_id' => $_SESSION['utilisateur']['id'] ?? 0
    ];

    // 🔍 Recherche par mot-clé (titre ou description)
    if (!empty($filtres['search'])) {
        $sql .= " AND (LOWER(o.titre) LIKE LOWER(:search) OR LOWER(o.description) LIKE LOWER(:search))";
        $params[':search'] = '%' . strtolower($filtres['search']) . '%';
    }

    // 🎯 Filtrer par domaine (mineure)
    if (!empty($filtres['domaine'])) {
        $sql .= " AND LOWER(o.mineure) = LOWER(:domaine)";
        $params[':domaine'] = strtolower($filtres['domaine']);
    }

    try {
        error_log("SQL Générée : " . $sql);
        error_log("Paramètres : " . print_r($params, true));

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        return [];
    }
}

}
?>

