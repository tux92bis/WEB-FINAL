<?php
session_start();
require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/entreprise.php';

$error = '';
$success = '';
$offres_par_entreprise = [];

$bdd = connexionBDD();
$entrepriseModel = new Entreprise($bdd);

try {
    // Récupérer toutes les entreprises avec leurs offres
    $sql = "SELECT 
                e.id_entreprise, 
                e.nom as entreprise_nom, 
                e.logo_path,
                o.id_offre,
                o.titre,
                o.description,
                o.type,
                o.mineure,
                o.base_remuneration,
                o.date_debut,
                o.date_fin
            FROM Entreprise e
            LEFT JOIN OffreStage o ON e.id_entreprise = o.id_entreprise
            ORDER BY e.nom, o.date_debut DESC";
    
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Grouper les offres par entreprise
    foreach ($resultats as $row) {
        $entreprise_id = $row['id_entreprise'];
        
        if (!isset($offres_par_entreprise[$entreprise_id])) {
            $offres_par_entreprise[$entreprise_id] = [
                'entreprise_nom' => $row['entreprise_nom'],
                'logo_path' => $row['logo_path'],
                'offres' => []
            ];
        }
        
        // Ajouter l'offre seulement si elle existe (LEFT JOIN peut retourner des NULL)
        if ($row['id_offre'] !== null) {
            $offres_par_entreprise[$entreprise_id]['offres'][] = [
                'id_offre' => $row['id_offre'],
                'titre' => $row['titre'],
                'description' => $row['description'],
                'type' => $row['type'],
                'mineure' => $row['mineure'],
                'base_remuneration' => $row['base_remuneration'],
                'date_debut' => $row['date_debut'],
                'date_fin' => $row['date_fin']
            ];
        }
    }

    // Récupérer les favoris si l'utilisateur est connecté
    if (isset($_SESSION['user_id'])) {
        $stmt = $bdd->prepare("SELECT offre_id FROM Favoris WHERE utilisateur_id = :user_id");
        $stmt->execute([':user_id' => $_SESSION['user_id']]);
        $favoris = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
} catch (PDOException $e) {
    $error = "Erreur lors de la récupération des données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr" data-wf-page="67bc8b3b85b97883c844e28c" data-wf-site="67b49e8f9c9f8a910dad1bec">
<head>
  <meta charset="utf-8">
  <title>Entreprises</title>
  <meta content="entreprise" property="og:title">
  <meta content="entreprise" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/stage-horizon.css" rel="stylesheet" type="text/css">
  <style>
    .entreprise-group {
        margin-bottom: 40px;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
    }
    .entreprise-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .entreprise-logo {
        width: 80px;
        height: 80px;
        object-fit: contain;
        margin-left: 20px;
    }
    .offres-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    .cell {
        border: 1px solid #eee;
        padding: 15px;
        border-radius: 5px;
    }
  </style>
  <script>!function (o, c) { var n = c.documentElement, t = " w-mod-"; n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch") }(window, document);</script>
</head>

<body>
  <header>
    <div data-animation="default" data-collapse="all" data-duration="400" data-easing="ease" data-easing2="ease"
      role="banner" class="navbar w-nav">
      <a href="#" class="w-nav-brand">
        <img src="images/logo-site.png" loading="lazy" width="100" sizes="(max-width: 479px) 71vw, 112.99479675292969px"
          alt="" srcset="images/logo-site-p-500.png 500w, images/logo-site.png 577w">
      </a>
      <div class="menu w-container">
        <nav class="navigation">
          <a href="accueil.php" aria-current="page" class="a w--current">Accueil</a>
          <a href="favoris.php" class="favoris">Favoris</a>
          <a href="candidature.php" class="favoris">Candidatures</a>
          <a href="entreprise.php" class="favoris">Entreprises</a>
        </nav>
        <div class="w-nav-button">
          <div data-hover="false" data-delay="50" class="w-dropdown">
            <div class="compte w-dropdown-toggle">
              <div class="w-icon-dropdown-toggle"></div>
              <div> Compte</div>
            </div>
            <nav class="w-dropdown-list">
              <a href="creerEntreprise.php" class="dropdown-link w-dropdown-link">Ajouter une entreprise</a>
              <a href="creerUtilisateur.php" class="dropdown-link-2 w-dropdown-link">Ajouter un utilisateur</a>
              <a href="creerOffre.php" class="dropdown-link-3 w-dropdown-link">Ajouter une offre</a>
            </nav>
          </div>
          <img src="images/generic-avatar.svg" loading="lazy" width="36" alt="" class="image">
        </div>
      </div>
    </div>
  </header>

  <section class="bandeau">
    <h1 class="slogan">Votre avenir commence ici !</h1>
  </section>
 
  <div class="w-layout-layout offres wf-layout-layout">
    <?php if (!empty($offres_par_entreprise)): ?>
      <?php foreach ($offres_par_entreprise as $entreprise_id => $entreprise_data): ?>
        <div class="entreprise-group">
          <div class="entreprise-header">
            <h2 class="heading-2"><?= htmlspecialchars($entreprise_data['entreprise_nom']) ?></h2>
            <?php if (!empty($entreprise_data['logo_path'])): ?>
              <img src="<?= htmlspecialchars($entreprise_data['logo_path']) ?>" alt="Logo <?= htmlspecialchars($entreprise_data['entreprise_nom']) ?>" class="entreprise-logo">
            <?php endif; ?>
          </div>
          
          <?php if (!empty($entreprise_data['offres'])): ?>
            <div class="offres-container">
              <?php foreach ($entreprise_data['offres'] as $index => $offre): 
                $checkboxId = 'checkbox-' . $entreprise_id . '-' . $index;
              ?>
                <div class="w-layout-cell cell">
                  <img src="images/bandeau-offre.png" loading="lazy" alt="" class="image-5">
                  <h3><?= htmlspecialchars($offre['titre']) ?></h3>
                  <p class="paragraph"><?= htmlspecialchars($offre['description']) ?></p>

                  <div class="offre-details">
                    <p><strong>Type:</strong> <?= htmlspecialchars($offre['type'] ?? 'Non spécifié') ?></p>
                    <p><strong>Rémunération:</strong> <?= $offre['base_remuneration'] ?>€</p>
                    <p><strong>Dates:</strong> <?= date('d/m/Y', strtotime($offre['date_debut'])) ?> - <?= date('d/m/Y', strtotime($offre['date_fin'])) ?></p>
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
                  <?php if (isset($_SESSION['user_id'])): ?>
                    <button onclick="ajouterFavori(this, <?= $offre['id_offre'] ?>)" class="favoris-btn">
                      <?= isset($favoris) && in_array($offre['id_offre'], $favoris) ? '★' : '☆' ?>
                    </button>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p>Aucune offre disponible pour cette entreprise</p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucune entreprise avec offres trouvée</p>
    <?php endif; ?>
  </div>

  <footer class="pied-de-page">
    <div class="w-layout-hflex contacts">
      <img loading="lazy" src="images/instagram.svg" alt="" class="instagram">
      <img loading="lazy" src="images/twitter.svg" alt="" class="twitter">
      <img loading="lazy" src="images/linkedin.svg" alt="" class="linkedin">
      <img loading="lazy" src="images/facebook.svg" alt="" class="facebook">
      <img loading="lazy" src="images/youtube.svg" alt="" class="image-18">
    </div>
    <div class="mention-l-gales">© 2025 StageHorizon | Inc. Tous droits réservés CGU</div>
  </footer>
  <script src="js/script.js" defer></script>
</body>
</html>
