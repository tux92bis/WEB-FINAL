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
        $entreprise = new Entreprise($this->bdd);
        $this->id_entreprise_test = $entreprise->ajouterEntreprise([
            'nom' => 'Entreprise Test',
            'secteur' => 'IT',
            'localisation' => 'Paris',
            'description' => 'Description test'
        ]);
    }

    protected function tearDown(): void
    {
        $this->bdd->exec("DELETE FROM Entreprise WHERE nom LIKE 'Entreprise Test'");
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
            'id_entreprise' => 1,
            'id_pilote' => 1,
            'id_admin' => 1  // Ajout de cette valeur
        ];

        $id = $this->offreStage->creerOffre($data);
        $this->assertNotNull($id);
    }

    public function testFiltreOffres()
    {
        // Nettoyer les offres ayant le titre spécifique avant le test
        $titreTest = 'Stage PHP Test Unique';
        $stmt = $this->bdd->prepare("DELETE FROM OffreStage WHERE titre = ?");
        $stmt->execute([$titreTest]);

        $this->offreStage->creerOffre([
            'titre' => $titreTest,
            'description' => 'Test uniquement',
            'type' => 'Stage',
            'base_remuneration' => 1000,
            'id_entreprise' => 1,
            'id_pilote' => 1,
            'id_admin' => 1
        ]);

        $filtres = [
            'type' => 'Stage',
            'search' => $titreTest
        ];

        $resultats = $this->offreStage->offresFiltrees($filtres);
        $this->assertCount(1, $resultats);
    }
}