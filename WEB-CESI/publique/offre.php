<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/entreprise.php'; // Nécessaire pour $entrepriseModel

$error = '';
$success = '';
$offres_paginees = [];
$favoris = [];

try {
    $bdd = connexionBDD();
    if (!$bdd) {
        die("Échec de connexion à la base de données.");
    }
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialisation du modèle Entreprise
    $entrepriseModel = new Entreprise($bdd);

    // Requête SQL simplifiée (sans logo_path)
    $sql = "SELECT o.*, e.nom as entreprise_nom
            FROM OffreStage o
            INNER JOIN Entreprise e ON o.id_entreprise = e.id_entreprise
            WHERE o.id_entreprise = :entreprise_id
            ORDER BY e.nom, o.date_debut DESC";
    
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':entreprise_id', $_GET['entreprise'], PDO::PARAM_INT);
    $stmt->execute();
    
    $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Gestion des favoris
    if (isset($_SESSION['user_id'])) {
        if (isset($_POST['add_favori'])) {
            $stmt = $bdd->prepare("
                INSERT INTO Favoris (utilisateur_id, offre_id, date_ajout)
                VALUES (:user_id, :offre_id, CURRENT_TIMESTAMP)
            ");
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':offre_id' => $_POST['offre_id']
            ]);
            $success = "Offre ajoutée aux favoris !";
        }

        $stmt = $bdd->prepare("SELECT offre_id FROM Favoris WHERE utilisateur_id = :user_id");
        $stmt->execute([':user_id' => $_SESSION['user_id']]);
        $favoris = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

} catch (PDOException $e) {
    $error = "Erreur SQL: " . $e->getMessage();
} catch (Exception $e) {
    $error = "Erreur: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr" data-wf-page="67bf0b02b89e8d9fc73fa4f9" data-wf-site="67b49e8f9c9f8a910dad1bec">
<head>
  <meta charset="utf-8">
  <title>Offres - <?= htmlspecialchars($_GET['entreprise'] ?? '') ?></title>
  <meta content="offre" property="og:title">
  <meta content="offre" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/stage-horizon.css" rel="stylesheet" type="text/css">
  <script>
    !function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);
    
    function ajouterFavori(button, offreId) {
        fetch('offre.php?entreprise=<?= $_GET['entreprise'] ?? '' ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'add_favori=1&offre_id=' + offreId
        }).then(response => {
            if (response.ok) {
                button.innerHTML = '★';
                button.style.color = 'gold';
            }
        });
    }
  </script>
</head>

<body class="body-2">
  <section class="bandeau">
    <h1 class="slogan">Votre avenir commence ici !</h1>
  </section>

  <div class="w-layout-layout offres wf-layout-layout">
    <?php if (!empty($offres)): ?>
      <?php foreach ($offres as $index => $offre): 
        $entreprise = $entrepriseModel->avoirParID($offre['id_entreprise']);
        $checkboxId = 'checkbox-' . $index;
      ?>
        <div class="w-layout-cell cell">
          <h2 class="heading-2"><?= htmlspecialchars($offre['entreprise_nom']) ?></h2>
          <img src="images/bandeau-offre.png" loading="lazy" alt="" class="image-5">
          <h3><?= htmlspecialchars($offre['titre']) ?></h3>
          <p class="paragraph"><?= htmlspecialchars($offre['description']) ?></p>

          <div class="offre-details">
            <p><strong>Type:</strong> <?= htmlspecialchars($offre['type']) ?></p>
            <p><strong>Rémunération:</strong> <?= htmlspecialchars($offre['base_remuneration']) ?>€</p>
            <p><strong>Dates:</strong> <?= date('d/m/Y', strtotime($offre['date_debut'])) ?> - <?= date('d/m/Y', strtotime($offre['date_fin'])) ?></p>
            <p><strong>Domaine:</strong> <?= htmlspecialchars($offre['mineure']) ?></p>
          </div>

          <a href="postuler.php?id=<?= $offre['id_offre'] ?>" class="button-2 w-button">Postuler</a>

          <label for="<?= $checkboxId ?>" class="toggle">
            <div class="bars"></div>
            <div class="bars"></div>
            <div class="bars"></div>
          </label>
          <input type="checkbox" id="<?= $checkboxId ?>" class="hidden-checkbox">

          <div class="modifsupp">
            <a href="modifier-offre.php?id=<?= $offre['id_offre'] ?>">Modifier</a>
            <form method="post" action="supprimer-offre.php" style="display:inline;">
              <input type="hidden" name="id_offre" value="<?= $offre['id_offre'] ?>">
              <button type="submit" class="btn-supprimer">Supprimer</button>
            </form>
          </div>

          <?php if (isset($_SESSION['user_id'])): ?>
            <button onclick="ajouterFavori(this, <?= $offre['id_offre'] ?>)" class="favoris-btn">
              <?= in_array($offre['id_offre'], $favoris) ? '★' : '☆' ?>
            </button>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="no-results">
        <p>Aucune offre trouvée pour cette entreprise.</p>
        <?php if ($error): ?>
          <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>

  <footer class="pied-de-page">
    <div class="w-layout-hflex contacts">
      <img loading="lazy" src="images/instagram.svg" alt="" class="instagram">
      <img loading="lazy" src="images/twitter.svg" alt="" class="twitter">
      <img loading="lazy" src="images/linkedin.svg" alt="" class="linkedin">
      <img loading="lazy" src="images/facebook.svg" alt="" class="facebook">
      <img loading="lazy" src="images/youtube.svg" alt="" class="image-26">
    </div>
    <div class="mention-l-gales">© 2025 StageHorizon | Inc. Tous droits réservés CGU</div>
  </footer>

  <script src="../js/script.js" defer></script>
</body>
</html>