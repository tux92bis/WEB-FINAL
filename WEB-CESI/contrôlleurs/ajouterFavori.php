<?php
require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/favoris.php';

session_start();
error_log("Session dans ajouterFavori.php : " . print_r($_SESSION, true));

if (!isset($_SESSION['user'])) {
    error_log("Utilisateur non connecté dans ajouterFavori.php");
    die("Non connecté");
}

$bdd = connexionBDD();
$favorisModel = new Favoris($bdd);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Tentative d'ajout de favori - ID utilisateur : " . $_SESSION['user']['id'] . ", ID offre : " . $_POST['id_offre']);

    // Récupérer l'ID de l'étudiant
    $stmt = $bdd->prepare("SELECT id_etudiant FROM Etudiant WHERE id_utilisateur = ?");
    $stmt->execute([$_SESSION['user']['id']]);
    $etudiant = $stmt->fetch();

    error_log("ID étudiant trouvé : " . print_r($etudiant, true));

    if ($etudiant) {
        $result = $favorisModel->ajouterFavori($etudiant['id_etudiant'], $_POST['id_offre']);
        error_log("Résultat de l'ajout du favori : " . ($result ? "succès" : "échec"));
    } else {
        error_log("Aucun étudiant trouvé pour l'utilisateur ID : " . $_SESSION['user']['id']);
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER'] ?? 'accueil.php');