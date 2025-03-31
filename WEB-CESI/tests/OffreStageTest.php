<?php
use PHPUnit\Framework\TestCase;

class OffreStageTest extends TestCase
{
    private $bdd;
    private $offreStage;

    protected function setUp(): void
    {
        $this->bdd = new PDO("sqlite::memory:");
        // Créer les tables nécessaires
        $this->bdd->exec("CREATE TABLE OffreStage (
            id_offre INTEGER PRIMARY KEY AUTOINCREMENT,
            titre TEXT NOT NULL,
            description TEXT,
            date_debut TEXT,
            date_fin TEXT,
            type TEXT,
            base_remuneration REAL
        )");
        
        $this->offreStage = new OffreStage($this->bdd);
    }

    public function testCreationOffre()
    {
        $data = [
            'titre' => 'Stage développeur',
            'description' => 'Description du stage',
            'date_debut' => '2024-06-01',
            'date_fin' => '2024-12-31',
            'type' => 'Stage',
            'base_remuneration' => 1000
        ];

        $id = $this->offreStage->creerOffre($data);
        $this->assertNotNull($id);
        
        $offre = $this->offreStage->getOffreById($id);
        $this->assertEquals($data['titre'], $offre['titre']);
    }

    public function testFiltreOffres()
    {
        // Ajouter quelques offres de test
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