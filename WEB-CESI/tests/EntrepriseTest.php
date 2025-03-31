<?php
use PHPUnit\Framework\TestCase;

class EntrepriseTest extends TestCase
{
    private $bdd;
    private $entreprise;

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