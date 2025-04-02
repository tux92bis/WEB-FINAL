<?php
require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/OffreStage.php';

session_start();
if ($_SESSION['user']['role'] !== 'admin') {
    die("Accès non autorisé");
}

$bdd = connexionBDD();
$offreModel = new OffreStage($bdd);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_offre'])) {
    $id_offre = (int)$_POST['id_offre'];
    
    if ($offreModel->supprimerOffre($id_offre)) {
        $_SESSION['message'] = "Offre supprimée avec succès";
    } else {
        $_SESSION['erreur'] = "Échec de la suppression. L'offre n'existe peut-être pas.";
    }
    
    // Redirection vers la liste des offres
    header('Location: liste-offres.php');
    exit;
}

// Si on arrive ici, c'est une requête invalide
$_SESSION['erreur'] = "Requête invalide";
header('Location: accueil.php');
exit;