<?php

class Entreprise
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function ajouterEntreprise($data)
    {
        $sql = "INSERT INTO Entreprise (nom, secteur, localisation, description) 
                VALUES (:nom, :secteur, :localisation, :description)";

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            ':nom' => $data['nom'],
            ':secteur' => $data['secteur'],
            ':localisation' => $data['localisation'],
            ':description' => $data['description']
        ]);

        return $this->bdd->lastInsertId();
    }

    public function avoirParID($id)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM Entreprise WHERE id_entreprise = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function toutesLesEntreprises()
    {
        $sql = "SELECT e.*, 
                (SELECT COUNT(*) FROM OffreStage WHERE id_entreprise = e.id_entreprise) as nombre_offres,
                (SELECT AVG(note) FROM Entreprise WHERE id_entreprise = e.id_entreprise) as moyenne_notes
                FROM Entreprise e
                ORDER BY e.nom";

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function offresEntreprise($id_entreprise)
    {
        $sql = "SELECT o.*, e.nom as nom_entreprise
                FROM OffreStage o
                JOIN Entreprise e ON o.id_entreprise = e.id_entreprise
                WHERE o.id_entreprise = ?";

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$id_entreprise]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function rechercherEntreprises($recherche)
    {
        $sql = "SELECT * FROM Entreprise 
                WHERE nom LIKE :recherche 
                OR secteur LIKE :recherche 
                OR localisation LIKE :recherche";

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([':recherche' => "%$recherche%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function statistiquesEntreprise($id_entreprise)
    {
        $sql = "SELECT 
                COUNT(o.id_offre) as total_offres,
                COUNT(c.id_candidature) as total_candidatures,
                e.note as note_moyenne
                FROM Entreprise e
                LEFT JOIN OffreStage o ON e.id_entreprise = o.id_entreprise
                LEFT JOIN Candidature c ON o.id_offre = c.id_offre
                WHERE e.id_entreprise = ?
                GROUP BY e.id_entreprise";

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$id_entreprise]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}