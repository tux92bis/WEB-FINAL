<?php
session_start();
require_once __DIR__ . '/../config/BDD.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_utilisateur'])) {
  header('Location: connexion.php');
  exit();
}

$bdd = connexionBDD();

// Récupérer l'ID de l'étudiant
$stmt = $bdd->prepare("SELECT id_etudiant FROM Etudiant WHERE id_utilisateur = ?");
$stmt->execute([$_SESSION['user']['id_utilisateur']]);
$etudiant = $stmt->fetch();

if ($etudiant) {
  // Récupérer les candidatures avec les informations de l'offre et de l'entreprise
  $stmt = $bdd->prepare("
        SELECT c.*, o.titre, o.type, o.base_remuneration,
               e.nom as nom_entreprise, e.localisation,
               DATE_FORMAT(c.date_candidature, '%d/%m/%Y') as date_formatee
        FROM Candidature c
        INNER JOIN OffreStage o ON c.id_offre = o.id_offre
        INNER JOIN Entreprise e ON o.id_entreprise = e.id_entreprise
        WHERE c.id_etudiant = :id_etudiant
        ORDER BY c.date_candidature DESC
    ");

  $stmt->execute([':id_etudiant' => $etudiant['id_etudiant']]);
  $candidatures = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  $candidatures = [];
}
?>
<html lang="fr" data-wf-page="67bf1b3b07f212818b80ddf5" data-wf-site="67b49e8f9c9f8a910dad1bec">

<head>
  <meta charset="utf-8">
  <title>candidature</title>
  <meta content="candidature" property="og:title">
  <meta content="candidature" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">

  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/stage-horizon.css" rel="stylesheet" type="text/css">

  <script>
    !function (o, c) {
      var n = c.documentElement,
        t = " w-mod-";
      n.className += t + "js",
        ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
    }(window, document);
  </script>
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
          <a href="historique.php" class="favoris">Candidatures</a>
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
              <a href="creerUtilisateur.php" class="dropdown-link-2 w-dropdown-link">Ajouter un utilisateur</a>
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
  <section>
    <div class="contenu">
      <h1>Historique des candidatures</h1>
      <?php if (!empty($candidatures)): ?>
        <?php foreach ($candidatures as $candidature): ?>
          <div class="offre-card">
            <div class="offre-title"><?= htmlspecialchars($candidature['titre']) ?></div>
            <div class="offre-info">
              <p><strong>Entreprise :</strong> <?= htmlspecialchars($candidature['nom_entreprise']) ?></p>
              <p><strong>Localisation :</strong> <?= htmlspecialchars($candidature['localisation']) ?></p>
              <p><strong>Type :</strong> <?= htmlspecialchars($candidature['type']) ?></p>
              <p><strong>Rémunération :</strong> <?= htmlspecialchars($candidature['base_remuneration']) ?>€</p>
              <p><strong>Date de candidature :</strong> <?= htmlspecialchars($candidature['date_formatee']) ?></p>
              <?php if ($candidature['cv']): ?>
                <p><a href="<?= htmlspecialchars($candidature['cv']) ?>" target="_blank">Voir le CV</a></p>
              <?php endif; ?>
              <?php if ($candidature['lettre_motivation']): ?>
                <p><a href="<?= htmlspecialchars($candidature['lettre_motivation']) ?>" target="_blank">Voir la lettre de
                    motivation</a></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="no-candidatures">Vous n'avez pas encore postulé à des offres.</p>
      <?php endif; ?>
    </div>
  </section>
  <footer class="pied-de-page">
    <div class="w-layout-hflex contacts">
      <img loading="lazy" src="images/instagram.svg" alt="" class="instagram">
      <img loading="lazy" src="images/twitter.svg" alt="" class="twitter">
      <img loading="lazy" src="images/linkedin.svg" alt="" class="linkedin">
      <img loading="lazy" src="images/facebook.svg" alt="" class="facebook">
      <img loading="lazy" src="images/youtube.svg" alt="" class="image-32">
    </div>

    <div class="mention-l-gales">
      © 2025 StageHorizon | Inc. Tous droits réservés CGU
    </div>
  </footer>
  <script src="js/script.js" defer></script>


</body>

</html>