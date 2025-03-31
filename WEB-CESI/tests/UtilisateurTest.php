<?php
use PHPUnit\Framework\TestCase;

class UtilisateurTest extends TestCase
{
    private $bdd;
    private $utilisateur;

    public function connexionBDD(): void
    {
        require_once __DIR__ . '/../config/BDD.php';
        $this->bdd = connexionBDD();
        $this->utilisateur = new Utilisateur($this->bdd);
    }
        

    public function testCreationUtilisateur()
    {
        $data = [
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean.dupont@test.com',
            'mot_de_passe' => 'test123',
            'role' => 'etudiant'
        ];

        $id = $this->utilisateur->creerUtilisateur($data);
        $this->assertNotNull($id);
        
        $user = $this->utilisateur->avoirParID($id);
        $this->assertEquals($data['email'], $user['email']);
    }

    public function testEmailExistant()
    {
        $email = 'test@test.com';
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