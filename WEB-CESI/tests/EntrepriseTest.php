<?php
use PHPUnit\Framework\TestCase;

class EntrepriseTest extends TestCase
{
    private $bdd;
    private $entreprise;

    protected function setUp(): void
    {
        $this->bdd = new PDO("sqlite::memory:");
        // Créer les tables nécessaires pour les tests
        $this->bdd->exec("CREATE TABLE Entreprise (
            id_entreprise INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT NOT NULL,
            secteur TEXT,
            localisation TEXT,
            description TEXT
        )");
        
        $this->entreprise = new Entreprise($this->bdd);
    }

    public function testAjoutEntreprise()
    {
        $data = [
            'nom' => 'Test Enterprise',
            'secteur' => 'IT',
            'localisation' => 'Paris',
            'description' => 'Description test'
        ];

        $id = $this->entreprise->ajouterEntreprise($data);
        $this->assertNotNull($id);
        
        $entreprise = $this->entreprise->avoirParID($id);
        $this->assertEquals($data['nom'], $entreprise['nom']);
    }

    public function testRechercheEntreprise()
    {
        $this->entreprise->ajouterEntreprise([
            'nom' => 'Tech Company',
            'secteur' => 'IT',
            'localisation' => 'Lyon'
        ]);

        $resultats = $this->entreprise->rechercherEntreprises('Tech');
        $this->assertCount(1, $resultats);
        $this->assertEquals('Tech Company', $resultats[0]['nom']);
    }
}