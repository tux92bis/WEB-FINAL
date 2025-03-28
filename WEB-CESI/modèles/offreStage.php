<?php
class OffreStage
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }
    public function offresFiltrees()
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
                INNER JOIN Entreprise e ON o.id_entreprise = e.id_entreprise";

        $user_id = isset($_SESSION['utilisateur']['id']) ? $_SESSION['utilisateur']['id'] : 0;
        $params = [':user_id' => $user_id];

        try {
            $stmt = $this->bdd->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Pour le débogage
            error_log($e->getMessage());
            return [];
        }
    }
}