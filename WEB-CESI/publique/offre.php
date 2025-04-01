<?php
session_start();
require_once __DIR__ . '/../config/BDD.php';

$error = '';
$success = '';
$offres_paginees = [];
$offres_par_entreprise = []; // This will group offers by enterprise

try {
    $bdd = connexionBDD();
    
    // Query to get all offers with enterprise information
    $stmt = $bdd->prepare("
        SELECT o.*, e.nom as entreprise_nom, e.logo_path
        FROM OffreStage o
        INNER JOIN Entreprise e ON o.id_entreprise = e.id_entreprise
        ORDER BY e.nom, o.date_debut DESC
    ");
    $stmt->execute();
    $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Group offers by enterprise
    foreach ($offres as $offre) {
        $entreprise_id = $offre['id_entreprise'];
        if (!isset($offres_par_entreprise[$entreprise_id])) {
            $offres_par_entreprise[$entreprise_id] = [
                'entreprise_nom' => $offre['entreprise_nom'],
                'logo_path' => $offre['logo_path'],
                'offres' => []
            ];
        }
        $offres_par_entreprise[$entreprise_id]['offres'][] = $offre;
    }

    if (isset($_SESSION['user_id'])) {
        if (isset($_POST['add_favori'])) {
            $offre_id = $_POST['offre_id'];
            
            $stmt = $bdd->prepare("
                INSERT INTO Favoris (utilisateur_id, offre_id, date_ajout)
                VALUES (:user_id, :offre_id, NOW())
            ");
            
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':offre_id' => $offre_id
            ]);
            
            $success = "Offre ajoutée aux favoris";
            header("Refresh: 1");
        }

        $stmt = $bdd->prepare("
            SELECT offre_id 
            FROM Favoris 
            WHERE utilisateur_id = :user_id
        ");
        $stmt->execute([':user_id' => $_SESSION['user_id']]);
        $favoris = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

} catch (Exception $e) {
    $error = "Erreur lors de la récupération des offres: " . $e->getMessage();
}
?>
<html lang="fr" data-wf-page="67bf0b02b89e8d9fc73fa4f9" data-wf-site="67b49e8f9c9f8a910dad1bec">

<head>
  <meta charset="utf-8">
  <title>offre</title>
  <meta content="offre" property="og:title">
  <meta content="offre" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/stage-horizon.css" rel="stylesheet" type="text/css">
  <script>!function (o, c) { var n = c.documentElement, t = " w-mod-"; n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch") }(window, document);</script>
</head>

<body class="body-2">


  <section class="bandeau">
    <h1 class="slogan"> Votre avenir commence ici !</h1>
  </section>
  <div class="w-layout-layout offres wf-layout-layout">
    <?php if (!empty($offres_paginees)): ?>
      <?php foreach ($offres_paginees as $index => $offre):
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
            <p><strong>Rémunération:</strong> <?= $offre['base_remuneration'] ?>€</p>
            <p><strong>Dates:</strong> Avril 2025 - Juin 2025</p>
            <p><strong>Domaine:</strong> <?= htmlspecialchars($offre['mineure']) ?></p>
          </div>

          <a href="postuler.php?id=<?= $offre['id_offre'] ?>" class="button-2 w-button">Postuler</a>

          <label for="<?= $checkboxId ?>" class="toggle">
            <div class="bars"></div>
            <div class="bars"></div>
            <div class="bars"></div>
          </label>
          <input type="checkbox" id="<?= $checkboxId ?>" class="hidden-checkbox" />


          <div class="modifsupp">
            <a href="modifier-offre.php?id=<?= $offre['id_offre'] ?>">Modifier</a>
            <form method="post" action="supprimer-offre.php" style="display:inline;">
              <input type="hidden" name="id_offre" value="<?= $offre['id_offre'] ?>">
              <button type="submit" class="btn-supprimer">Supprimer</button>
            </form>
          </div>
          <button onclick="ajouterFavori(this, <?= $offre['id_offre'] ?>)" class="favoris-btn">
          <?= in_array($offre['id_offre'], $favoris ?? []) ? '★' : '☆' ?>

          </button>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun résultat trouvé pour : "<?= htmlspecialchars($_GET['search']) ?>"</p>
    <?php endif; ?>
  </div>


  <footer class="pied-de-page">
    <div class="w-layout-hflex contacts"><img loading="lazy" src="images/instagram.svg" alt="" class="instagram"><img
        loading="lazy" src="images/twitter.svg" alt="" class="twitter"><img loading="lazy" src="images/linkedin.svg"
        alt="" class="linkedin"><img loading="lazy" src="images/facebook.svg" alt="" class="facebook"><img
        loading="lazy" src="images/youtube.svg" alt="" class="image-26"></div>
    <div class="mention-l-gales">© 2025 StageHorizon | Inc. Tous droits réservés CGU</div>
  </footer>
  <script src="../js/script.js" defer></script>
</body>

</html>