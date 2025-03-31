<?php
use PHPUnit\Framework\TestCase;

class UtilisateurTest extends TestCase
{
    private $bdd;
    private $utilisateur;

    protected function setUp(): void
    {
        $this->bdd = new PDO("sqlite::memory:");
        // Créer les tables nécessaires pour les tests
        $this->bdd->exec("CREATE TABLE Utilisateur (
            id_utilisateur INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT NOT NULL,
            prenom TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            mot_de_passe TEXT NOT NULL,
            role TEXT NOT NULL
        )");
        
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

        $id = $this->utilisateur->createUser($data);
        $this->assertNotNull($id);
        
        $user = $this->utilisateur->getUserById($id);
        $this->assertEquals($data['email'], $user['email']);
    }

    public function testEmailExistant()
    {
        $email = 'test@test.com';
        $this->assertFalse($this->utilisateur->emailExists($email));
        
        $this->utilisateur->createUser([
            'nom' => 'Test',
            'prenom' => 'User',
            'email' => $email,
            'mot_de_passe' => 'test123',
            'role' => 'etudiant'
        ]);
        
        $this->assertTrue($this->utilisateur->emailExists($email));
    }
}