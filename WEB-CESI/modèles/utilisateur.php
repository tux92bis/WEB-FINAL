<?php

class Utilisateur
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function emailExists($email)
    {
        $stmt = $this->bdd->prepare("SELECT 1 FROM Utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        return (bool) $stmt->fetch();
    }

    public function creerUtilisateur($data)
    {
        $sql = "INSERT INTO Utilisateur (nom, prenom, email, mot_de_passe, role) 
                VALUES (:nom, :prenom, :email, :mot_de_passe, :role)";

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':email' => $data['email'],
            ':mot_de_passe' => $data['mot_de_passe'],
            ':role' => $data['role']
        ]);

        return $this->bdd->lastInsertId();
    }
}