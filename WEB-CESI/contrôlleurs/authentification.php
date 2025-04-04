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

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            header('Location: accueil.php');
            return true;
        }
        return false;
    }
}