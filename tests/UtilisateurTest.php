<?php
use PHPUnit\Framework\TestCase;

class UtilisateurTest extends TestCase
{
    private $bdd;
    private $utilisateur;

    protected function setUp(): void
    {
        require_once __DIR__ . '/../WEB-CESI/config/BDD.php';
        require_once __DIR__ . '/../WEB-CESI/modèles/utilisateur.php';
        $this->bdd = connexionBDD();
        $this->utilisateur = new Utilisateur($this->bdd);
        $this->bdd->exec("DELETE FROM Utilisateur WHERE email LIKE 'test%@test.com'");
    }

    protected function tearDown(): void
    {
        $this->bdd->exec("DELETE FROM Utilisateur WHERE email LIKE 'test%@test.com'");
    }

    public function testCreationUtilisateur()
    {
        $uniqueEmail = 'test_' . time() . '@example.com'; 
        $data = [
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => $uniqueEmail,
            'mot_de_passe' => 'test123',
            'role' => 'etudiant'
        ];

        $id = $this->utilisateur->creerUtilisateur($data);
        $this->assertNotNull($id);
    }

    public function testEmailExistant()
    {
        $email = 'test' . time() . '@test.com'; 

        $this->assertFalse($this->utilisateur->emailExists($email));

        $this->utilisateur->creerUtilisateur([
            'nom' => 'Test',
            'prenom' => 'User',
            'email' => $email,
            'mot_de_passe' => 'test123',
            'role' => 'etudiant'
        ]);

        $this->assertTrue($this->utilisateur->emailExists($email));
    }
}