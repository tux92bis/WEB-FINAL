<?php
class Favoris {
    private $bdd;
    
    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterFavori($id_utilisateur, $id_offre) {
        $stmt = $this->bdd->prepare("SELECT 1 FROM Favoris WHERE id_utilisateur = ? AND id_offre = ?");
        $stmt->execute([$id_utilisateur, $id_offre]);
        
        if ($stmt->fetch()) {
            $this->bdd->prepare("DELETE FROM Favoris WHERE id_utilisateur = ? AND id_offre = ?")
                     ->execute([$id_utilisateur, $id_offre]);
            return false;
        } else {
            $this->bdd->prepare("INSERT INTO Favoris (id_utilisateur, id_offre) VALUES (?, ?)")
                     ->execute([$id_utilisateur, $id_offre]);
            return true;
        }
    }
}