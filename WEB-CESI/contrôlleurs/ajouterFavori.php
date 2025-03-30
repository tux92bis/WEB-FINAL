<?php
require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/favoris.php';

session_start();
if (!isset($_SESSION['user'])) {
    die("Non connecté");
}

$bdd = connexionBDD();
$favorisModel = new Favoris($bdd);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $favorisModel->ajouterFavori($_SESSION['user']['id'], $_POST['id_offre']);
}

header('Location: ' . $_SERVER['HTTP_REFERER'] ?? 'accueil.php');