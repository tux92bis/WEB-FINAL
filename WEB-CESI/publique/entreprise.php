<?php

session_start();

require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/entreprise.php';

$error = '';
$success = '';

$bdd = connexionBDD();
$entrepriseModel = new Entreprise($bdd);

// Récupérer toutes les entreprises avec leurs offres et statistiques
$sql = "SELECT e.*, 
        (SELECT COUNT(*) FROM OffreStage WHERE id_entreprise = e.id_entreprise) as nombre_offres,
        (SELECT AVG(note) FROM Entreprise WHERE id_entreprise = e.id_entreprise) as moyenne_notes
        FROM Entreprise e 
        ORDER BY e.nom";

try {
  $stmt = $bdd->prepare($sql);
  $stmt->execute();
  $entreprises = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $entreprises = [];
  $_SESSION['error'] = "Erreur lors de la récupération des entreprises.";
}

?>

<html lang="fr" data-wf-page="67bc8b3b85b97883c844e28c" data-wf-site="67b49e8f9c9f8a910dad1bec">

<head>
  <meta charset="utf-8">
  <title>entreprise</title>
  <meta content="entreprise" property="og:title">
  <meta content="entreprise" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/stage-horizon.css" rel="stylesheet" type="text/css">
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
              <div> Compte</div>
            </div>
            <nav class="w-dropdown-list">
              <a href="creerEntreprise.php" class="dropdown-link w-dropdown-link">Ajouter une entreprise</a>
              <a href="creerUtilisateur .php" class="dropdown-link-2 w-dropdown-link">Ajouter un utilisateur</a>
              <a href="creerOffre.php" class="dropdown-link-3 w-dropdown-link">Ajouter une offre</a>

            </nav>
          </div><img src="images/generic-avatar.svg" loading="lazy" width="36" alt="" class="image">
        </div>
      </div>
    </div>
  </header>




  <section class="bandeau">
    <h1 class="slogan">Votre avenir commence ici !</h1>
  </section>

  <section class="offre">
    <img src="images/generic-avatar.svg" loading="lazy" width="54" alt="" class="image-4">
    <img src="images/map-pin.png" loading="lazy" alt="" class="localisation">
    <div class="text-block-2">Localisation</div>
    <img src="images/bandeau-offre.png" loading="lazy" alt="" class="image-30">
    <h2 class="nom-entreprise">Nom entreprise</h2>
    <a href="#" class="afficher-offres w-button">Afficher offres</a>
    <p class="informations"><strong>Informations </strong>: lor sit amet, consectetur adipiscing elit. Suspendisse
      varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut
      commodo diam libero vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae
      risus tristique posuer</p>
    <div class="contact">
      <a id="exe" href="mailto:exemple@gmail.com?subject=exemple%40gmail.com" class="link">exemple@gmail.com</a>
      <a href="tel:010203040506" class="link-2">0102030405</a>
      <img src="images/phone.png" loading="lazy" alt="" class="image-22">
      <img src="images/mail.png" loading="lazy" alt="" class="image-21">
    </div>
    <p>Évaluez l'entreprise :</p>
    <div id="stars">
      <button class="star">☆</button>
      <button class="star">☆</button>
      <button class="star">☆</button>
      <button class="star">☆</button>
    </div>
    <p id="note"></p>

  </section>

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

<div class="w-layout-grid grid">
  <?php if (!empty($entreprises)): ?>
    <?php foreach ($entreprises as $entreprise): ?>
      <div class="w-layout-cell cell-5">
        <h2 class="heading-2"><?= htmlspecialchars($entreprise['nom']) ?></h2>
        <img src="images/bandeau-offre.png" loading="lazy" alt="" class="image-5">

        <div class="text-block-2">
          <img src="images/map-pin.png" loading="lazy" alt="" class="localisation">
          <?= htmlspecialchars($entreprise['localisation']) ?>
        </div>

        <p class="paragraph"><?= htmlspecialchars($entreprise['description']) ?></p>

        <div class="info-entreprise">
          <p><strong>Secteur d'activité :</strong> <?= htmlspecialchars($entreprise['secteur']) ?></p>
          <p><strong>Nombre d'offres :</strong> <?= htmlspecialchars($entreprise['nombre_offres']) ?></p>
          <?php if ($entreprise['moyenne_notes']): ?>
            <p><strong>Note :</strong> <?= number_format($entreprise['moyenne_notes'], 1) ?>/5</p>
          <?php endif; ?>
        </div>

        <a href="offre.php?entreprise=<?= $entreprise['id_entreprise'] ?>" class="button-2 w-button">
          Voir les offres
        </a>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Aucune entreprise trouvée.</p>
  <?php endif; ?>
</div>