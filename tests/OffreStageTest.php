<?php
use PHPUnit\Framework\TestCase;

class OffreStageTest extends TestCase
{
    private $bdd;
    private $offreStage;
    private $id_entreprise_test;

    protected function setUp(): void
    {
        require_once __DIR__ . '/../WEB-CESI/config/BDD.php';
        require_once __DIR__ . '/../WEB-CESI/modèles/offreStage.php';
        require_once __DIR__ . '/../WEB-CESI/modèles/entreprise.php';

        $this->bdd = connexionBDD();
        $this->offreStage = new OffreStage($this->bdd);

        // Créer une entreprise de test
        $entreprise = new Entreprise($this->bdd);
        $this->id_entreprise_test = $entreprise->ajouterEntreprise([
            'nom' => 'Entreprise Test',
            'secteur' => 'IT',
            'localisation' => 'Paris',
            'description' => 'Description test'
        ]);
    }

    public function testCreationOffre()
    {
        $data = [
            'titre' => 'Stage développeur',
            'description' => 'Description du stage',
            'date_debut' => '2024-06-01',
            'date_fin' => '2024-12-31',
            'type' => 'Stage',
            'base_remuneration' => 1000,
            'id_entreprise' => $this->id_entreprise_test
        ];

        $id = $this->offreStage->creerOffre($data);
        $this->assertNotNull($id);

        $offre = $this->offreStage->avoirParID($id);
        $this->assertEquals($data['titre'], $offre['titre']);
    }

    public function testFiltreOffres()
    {
        $this->offreStage->creerOffre([
            'titre' => 'Stage PHP',
            'type' => 'Stage',
            'base_remuneration' => 1000
        ]);

        $filtres = ['type' => 'Stage'];
        $resultats = $this->offreStage->offresFiltrees($filtres);
        $this->assertCount(1, $resultats);
        $this->assertEquals('Stage PHP', $resultats[0]['titre']);
    }
}