<?php

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_utilisateur'])) {
    error_log("Utilisateur non connecté dans ajouterFavori.php");
    die("Non connecté");
}

$bdd = connexionBDD();
$favorisModel = new Favoris($bdd);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Tentative d'ajout de favori - ID utilisateur : " . $_SESSION['user']['id_utilisateur'] . ", ID offre : " . $_POST['id_offre']);

    // Récupérer l'ID de l'étudiant
    $stmt = $bdd->prepare("SELECT id_etudiant FROM Etudiant WHERE id_utilisateur = ?");
    $stmt->execute([$_SESSION['user']['id_utilisateur']]);
    $etudiant = $stmt->fetch();
    // ... existing code ...
}