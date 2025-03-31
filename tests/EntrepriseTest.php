<?php
use PHPUnit\Framework\TestCase;

class EntrepriseTest extends TestCase
{
    private $bdd;
    private $entreprise;

    protected function setUp(): void
    {
        require_once __DIR__ . '/../WEB-CESI/config/BDD.php';
        require_once __DIR__ . '/../WEB-CESI/modèles/entreprise.php';
        $this->bdd = connexionBDD();
        $this->entreprise = new Entreprise($this->bdd);

        // Nettoyer les données de test
        $this->bdd->exec("DELETE FROM Entreprise WHERE nom LIKE 'Test%'");
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
            'nom' => 'Test Tech Company',
            'secteur' => 'IT',
            'localisation' => 'Lyon'
        ]);

        $resultats = $this->entreprise->rechercherEntreprises('Test Tech');
        $this->assertCount(1, $resultats);
        $this->assertEquals('Test Tech Company', $resultats[0]['nom']);
    }
}