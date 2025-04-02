<?php
require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/favoris.php';


session_start();

error_log("Session: " . print_r($_SESSION, true));
error_log("POST: " . print_r($_POST, true));

header('Content-Type: text/plain'); // Important pour la réponse

if (!isset($_SESSION['user']['id_utilisateur'])) {
    http_response_code(401);
    die("Non connecté");
}

$bdd = connexionBDD();
$favorisModel = new Favoris($bdd);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_offre'])) {
    // Récupérer l'ID de l'étudiant
    $stmt = $bdd->prepare("SELECT id_etudiant FROM Etudiant WHERE id_utilisateur = ?");
    $stmt->execute([$_SESSION['user']['id_utilisateur']]);
    $etudiant = $stmt->fetch();

    if ($etudiant) {
        $result = $favorisModel->ajouterFavori($etudiant['id_etudiant'], $_POST['id_offre']);
        echo $result ? 'added' : 'removed';
        exit;
    } else {
        http_response_code(404);
        die("Aucun étudiant trouvé");
    }
}

http_response_code(400);
die("Requête invalide");