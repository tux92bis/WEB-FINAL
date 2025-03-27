<?php
require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/OffreStage.php';

session_start();
if ($_SESSION['user']['role'] !== 'admin') {
    die("Accès non autorisé");
}

$bdd = connexionBDD();
$offreModel = new OffreStage($bdd);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offreModel->supprimerOffre($_POST['id_offre']);
    $_SESSION['message'] = "Offre supprimée avec succès";
}

header('Location: accueil.php');