<?php




class Authentification
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function connexion($email, $mot_de_passe)
    {
        $query = "SELECT * FROM Utilisateur WHERE email = :email AND mot_de_passe = :mot_de_passe";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute([
            'email' => $email,
            'mot_de_passe' => $mot_de_passe
        ]);

        if ($stmt->fetch()) {
            session_start();
            $_SESSION['email'] = $email;
            header('Location: accueil.php');
        }
        return false;
    }
}