<?php
session_start();
require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/offreStage.php';
require_once __DIR__ . '/../modèles/entreprise.php';
require_once __DIR__ . '/../modèles/favoris.php';

$bdd = connexionBDD();

$filtres = [];
$offreModel = new OffreStage($bdd);
$entrepriseModel = new Entreprise($bdd);
$favorisModel = new Favoris($bdd);

$offres_par_page = 4;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1)
  $page = 1;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  if (!empty($_GET['search'])) {
    $filtres['search'] = $_GET['search'];
  }
  if (!empty($_GET['base_remuneration'])) {
    $filtres['base_remuneration'] = (float) $_GET['base_remuneration'];
  }
  if (!empty($_GET['Type'])) {
    $filtres['type'] = $_GET['Type'];
  }
  if (!empty($_GET['domaine']) && is_array($_GET['domaine'])) {
    $filtres['domaine'] = $_GET['domaine'];
  }
}

$toutes_offres = $offreModel->offresFiltrees($filtres);

$total_offres = count($toutes_offres);
$total_pages = ceil($total_offres / $offres_par_page);

if ($page > $total_pages && $total_pages > 0) {
  $page = $total_pages;
}

$offres_paginees = array_slice($toutes_offres, ($page - 1) * $offres_par_page, $offres_par_page);

foreach ($offres_paginees as &$offre) {
  $offre['type'] = $offre['type'] ?? 'Non spécifié';

  if (!empty($offre['date_de_debut']) && !empty($offre['date_de_fin'])) {
    try {
      $debut = new DateTime($offre['date_de_debut']);
      $fin = new DateTime($offre['date_de_fin']);
      $duree = $debut->diff($fin);
      $offre['duree'] = $duree->format('%m mois');
    } catch (Exception $e) {
      $offre['duree'] = 'Durée non spécifiée';
    }
  } else {
    $offre['date_de_debut'] = 'Non spécifiée';
    $offre['date_de_fin'] = 'Non spécifiée';
    $offre['duree'] = 'Durée non spécifiée';
  }
}
unset($offre);


?>

<html lang="fr" data-wf-page="67b49e8f9c9f8a910dad1bf7" data-wf-site="67b49e8f9c9f8a910dad1bec">

<head>
  <meta charset="utf-8">
  <title>Stage-Horizon</title>
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/stage-horizon.css" rel="stylesheet" type="text/css">
  <script>
    !function (o, c) { var n = c.documentElement, t = " w-mod-"; n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch") }(window, document);
  </script>
  <script>
    function ajouterFavori(button, idOffre) {
      fetch('ajouterFavori.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id_offre=' + idOffre
      })
        .then(response => {
          if (response.ok) {
            // Inverser l'état de l'étoile
            if (button.textContent === '☆') {
              button.textContent = '★';
            } else {
              button.textContent = '☆';
            }
          }
        });
    }
  </script>
</head>

<body class="body">
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
          <a href="historique.php" class="favoris">Candidatures</a>
          <a href="entreprise.php" class="favoris">Entreprises</a>
        </nav>
        <div class="w-nav-button">
          <div data-hover="false" data-delay="50" class="w-dropdown">
            <div class="compte w-dropdown-toggle">
              <div class="w-icon-dropdown-toggle"></div>
              <div>Compte</div>
            </div>
            <nav class="w-dropdown-list">
              <?php if (isset($_SESSION['utilisateur']['role']) && $_SESSION['utilisateur']['role'] === 'admin'): ?>
                <a href="creerEntreprise.php" class="dropdown-link w-dropdown-link">Ajouter une entreprise</a>
                <a href="creerUtilisateur.php" class="dropdown-link-2 w-dropdown-link">Ajouter un utilisateur</a>
                <a href="creerOffre.php" class="dropdown-link-3 w-dropdown-link">Ajouter une offre</a>
              <?php else: ?>
                <div class="dropdown-link w-dropdown-link text-muted">Accès réservé aux administrateurs</div>
              <?php endif; ?>
            </nav>
          </div>

          <img src="images/generic-avatar.svg" loading="lazy" width="36" alt="" class="image">
        </div>
      </div>
    </div>
  </header>

  <section class="bandeau">
    <h1 class="slogan">Votre avenir commence ici !</h1>
    <div class="search-bar-container">
      <form method="get" action="">
        <input type="text" name="search" placeholder="Rechercher..." class="search-input"
          value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit" class="search-button">🔍</button>
      </form>
    </div>
  </section>

  <aside class="filtres w-form">
    <form method="get" class="form">
      <h4>Filtrer les offres</h4>
      <div class="price-slider">
        <label for="base_rémunération">Gratification :</label>
        <div class="price-display">
          <span id="priceValue"><?= htmlspecialchars($_GET['base_remuneration'] ?? 500, ENT_QUOTES) ?></span> €
        </div>
        <input type="range" id="base_remuneration" name="base_remuneration" min="0" max="2000"
          value="<?= htmlspecialchars($_GET['base_remuneration'] ?? 1000, ENT_QUOTES) ?>" step="10"
          oninput="document.getElementById('priceValue').textContent = this.value">
      </div>


      <fieldset>
        <legend>Type de contrat</legend>
        <?php $currentType = $_GET['Type'] ?? ''; ?>
        <label class="w-radio">
          <input type="radio" name="Type" value="Alternance" <?= $currentType === 'Alternance' ? 'checked' : '' ?>>
          Alternance
        </label>
        <label class="w-radio">
          <input type="radio" name="Type" value="Stage" <?= $currentType === 'Stage' ? 'checked' : '' ?>> Stage
        </label>
      </fieldset>

      <fieldset>
        <legend>Domaines</legend>
        <?php
        $domaines = ['BTP', 'S3E', 'Informatique', 'Généraliste'];
        $selectedDomaines = isset($_GET['domaine']) ? (array) $_GET['domaine'] : [];
        foreach ($domaines as $domaine):
          ?>
          <label class="w-checkbox">
            <input type="checkbox" name="domaine[]" value="<?= $domaine ?>" <?= in_array($domaine, $selectedDomaines) ? 'checked' : '' ?>> <?= $domaine ?>
          </label>
        <?php endforeach; ?>
      </fieldset>

      <button type="submit" class="apply-filters">Appliquer les filtres</button>
      <?php if (!empty($_GET)): ?>
        <a href="accueil.php" class="reset-filters">Réinitialiser</a>
      <?php endif; ?>
    </form>
  </aside>
  <div class="w-layout-layout offres wf-layout-layout">
    <?php if (!empty($offres_paginees)): ?>
      <?php foreach ($offres_paginees as $index => $offre):
        $entreprise = $entrepriseModel->avoirParID($offre['id_entreprise']);
        $checkboxId = 'checkbox-' . $index;
        ?>
        <div class="w-layout-cell cell">
          <h2 class="heading-2"><?= htmlspecialchars($entreprise['nom']) ?></h2>
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
            <?= $offre['est_favori'] ? '★' : '☆' ?>
          </button>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun résultat trouvé pour : "<?= htmlspecialchars($_GET['search']) ?>"</p>
    <?php endif; ?>
  </div>
  <div class="pagination">
    <?php if ($total_pages > 1): ?>
      <?php if ($page > 1): ?>
        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">&laquo; Précédent</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <?php if ($i == $page): ?>
          <span class="current"><?= $i ?></span>
        <?php else: ?>
          <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
        <?php endif; ?>
      <?php endfor; ?>

      <?php if ($page < $total_pages): ?>
        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">Suivant &raquo;</a>
      <?php endif; ?>
    <?php endif; ?>
  </div>







  <footer class="pied-de-page">
    <div class="w-layout-hflex contacts">
      <img src="images/instagram.svg" loading="lazy" alt="" class="instagram">
      <img src="images/twitter.svg" loading="lazy" alt="" class="twitter">
      <img src="images/linkedin.svg" loading="lazy" alt="" class="linkedin">
      <img src="images/facebook.svg" loading="lazy" alt="" class="facebook">
      <img src="images/youtube.svg" loading="lazy" alt="" class="image-2">
    </div>
    <div class="mention-l-gales">© 2025 StageHorizon | Inc. Tous droits réservés CGU</div>
  </footer>
  <script>
    <?php if (!empty($_GET)): ?>
      document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[name^="domaine"], input[name="Type"]').forEach(input => {
          if (input.checked) {
            input.closest('label').classList.add('active-filter');
          }
        });
      });
    <?php endif; ?>
  </script>
  <script src="../js/script.js"></script>

</body>

</html>