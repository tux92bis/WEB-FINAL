<?php
session_start();
require_once __DIR__ . '/../config/BDD.php';

$error = '';
$success = '';

try {
    $bdd = connexionBDD();
    
    $stmt = $bdd->prepare("
        SELECT o.*, e.nom as entreprise_nom, e.logo_path
        FROM Offre o
        INNER JOIN Entreprise e ON o.entreprise_id = e.id
        ORDER BY o.date_debut DESC
    ");
    $stmt->execute();
    $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
  <header>
    <div data-animation="default" data-collapse="all" data-duration="400" data-easing="ease" data-easing2="ease"
      role="banner" class="navbar w-nav">
      <a href="#" class="w-nav-brand">
        <img src="images/logo-site.png" loading="lazy" width="100"
          sizes="(max-width: 479px) 71vw, 112.99479675292969px" alt=""
          srcset="images/logo-site-p-500.png 500w, images/logo-site.png 577w">
      </a>
      <div class="menu w-container">

        <nav  class="navigation">
          <a href="accueil.php" aria-current="page" class="a w--current">Accueil</a>
          <a href="favoris.php" class="favoris">Favoris</a>
          <a href="offre.php" class="favoris">Offres de stage</a>
          <a href="candidature.php" class="favoris">Candidatures</a>
          <a href="entreprise.php" class="favoris">Entreprises</a>
        </nav>
        <div  class="w-nav-button">
          <div data-hover="false" data-delay="50" class="w-dropdown">
            <div class="compte w-dropdown-toggle">
              <div class="w-icon-dropdown-toggle"></div>
              <div> Compte</div>
            </div>
            <nav class="w-dropdown-list">
              <a href="creerOffre.php" class="dropdown-link w-dropdown-link">Ajouter une offre</a>
              <a href="creerUtilisateur.php" class="dropdown-link-2 w-dropdown-link">Ajouter un utilisateur</a>
              <a href="creerEntreprise.php" class="dropdown-link-3 w-dropdown-link">Ajouter une entreprise</a>
            </nav>
          </div><img src="images/generic-avatar.svg" loading="lazy" width="36" alt="" class="image">
        </div>
      </div>
    </div>
  </header>


  <section class="bandeau">
    <h1 class="slogan"> Votre avenir commence ici !</h1>
  </section>

  <section class="offre">
    <img width="54" loading="lazy" alt="" src="images/generic-avatar.svg" class="image-4">
    <img loading="lazy" src="images/map-pin.png" alt="" class="localisation">
    <div class="text-block-2">Localisation</div><img loading="lazy" src="images/bandeau-offre.png" alt=""
      class="image-30">
    <h2 class="nom-entreprise offre">Nom entreprise</h2>

    <p class="informations">
      <strong>Informations </strong>: lor sit amet, consectetur adipiscing elit. Suspendisse
      varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut
      commodo diam libero vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae
      risus tristique posuer </p>
    <ul class="comp-tences">
      <li class="list-item">Compétences</li>
      <li class="list-item">Compétences</li>
      <li class="list-item">Compétences</li>
      <li class="list-item">Compétences</li>
    </ul>
    <ul class="list objectifs">
      <li class="list-item">Objectifs</li>
      <li class="list-item">Objectifs</li>
      <li class="list-item">Objectifs</li>
      <li class="list-item">Objectifs</li>
    </ul>
    <div>
      <a href="condidature.html" class="afficher-offres-1 w-button">Postuler</a>
    </div>
  </section>
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