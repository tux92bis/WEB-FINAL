<?php
use PHPUnit\Framework\TestCase;

class EntrepriseTest extends TestCase
{
    private $bdd;
    private $entreprise;

    protected function connexionBDD(): void
    {
      
        require_once __DIR__ . '/../config/BDD.php';
        $this->bdd = connexionBDD();
        $this->entreprise = new Entreprise($this->bdd);
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

    protected function nettoyer(): void
    {
        $this->bdd->exec("DELETE FROM Entreprise WHERE nom LIKE 'Test%'");
    }
}