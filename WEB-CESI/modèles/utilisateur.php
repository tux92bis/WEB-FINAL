<?php

class Utilisateur {
    private $bdd;
    
    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function emailExists($email) {
        $stmt = $this->bdd->prepare("SELECT 1 FROM Utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        return (bool)$stmt->fetch();
    }

    public function createUser($data) {
        $stmt = $this->bdd->prepare("
            INSERT INTO Utilisateur (nom, prenom, email, mot_de_passe, role, cv_path) 
            VALUES (:nom, :prenom, :email, :mot_de_passe, :role, :cv_path)
        ");
        $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':email' => $data['email'],
            ':mot_de_passe' => $data['mot_de_passe'],
            ':role' => $data['role'],
            ':cv_path' => $data['cv_path']
        ]);
        return $this->bdd->lastInsertId();
    }
}