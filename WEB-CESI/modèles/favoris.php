<?php
class Favoris {
    private $bdd;
    
    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterFavori($id_utilisateur, $id_entreprise) {
        if ($this->estFavori($id_utilisateur, $id_entreprise)) {
            $this->bdd->prepare("DELETE FROM Favoris WHERE id_utilisateur = ? AND id_entreprise = ?")
                     ->execute([$id_utilisateur, $id_entreprise]);
        } else {
            $this->bdd->prepare("INSERT INTO Favoris (id_utilisateur, id_entreprise) VALUES (?, ?)")
                     ->execute([$id_utilisateur, $id_entreprise]);
        }
    }

    public function estFavori($id_utilisateur, $id_entreprise) {
        $stmt = $this->bdd->prepare("SELECT 1 FROM Favoris WHERE id_utilisateur = ? AND id_entreprise = ?");
        $stmt->execute([$id_utilisateur, $id_entreprise]);
        return (bool)$stmt->fetch();
    }
}