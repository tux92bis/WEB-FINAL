<?php
session_start();
require_once __DIR__ . '/../config/BDD.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bdd = connexionBDD();

    // Récupération des données du formulaire
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $entreprise_id = trim($_POST['entreprise_id']);
    $type_contrat = trim($_POST['type_contrat']);
    $duree = trim($_POST['duree']);
    $remuneration = trim($_POST['remuneration']);
    $date_debut = trim($_POST['date_debut']);

    // Validation basique
    if (empty($titre) || empty($description) || empty($entreprise_id)) {
        $error = "Les champs titre, description et entreprise sont obligatoires";
    } else {
        try {
            $stmt = $bdd->prepare("
                INSERT INTO Offre (titre, description, entreprise_id, type_contrat, duree, remuneration, date_debut) 
                VALUES (:titre, :description, :entreprise_id, :type_contrat, :duree, :remuneration, :date_debut)
            ");
            
            $stmt->execute([
                ':titre' => $titre,
                ':description' => $description,
                ':entreprise_id' => $entreprise_id,
                ':type_contrat' => $type_contrat,
                ':duree' => $duree,
                ':remuneration' => $remuneration,
                ':date_debut' => $date_debut
            ]);

            $success = "Offre créée avec succès!";
            header("Refresh: 3; url=entreprise.php");

        } catch (Exception $e) {
            $error = "Erreur lors de la création de l'offre: " . $e->getMessage();
        }
    }
}
?>

<html lang="fr" data-wf-page="67c038fa0fbf3721b579cd1d" data-wf-site="67b49e8f9c9f8a910dad1bec">

<head>
  <meta charset="utf-8">
  <title>Créer offre</title>
  <meta content="Créer offre" property="og:title">
  <meta content="Créer offre" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
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
        <img src="images/logo-site.png" loading="lazy" width="100"
          sizes="(max-width: 479px) 71vw, 112.99479675292969px" alt=""
          srcset="images/logo-site-p-500.png 500w, images/logo-site.png 577w">
      </a>
      <div class="menu w-container">

        <nav  class="navigation">
          <a href="accueil.html" aria-current="page" class="a w--current">Accueil</a>
          <a href="favoris.php" class="favoris">Favoris</a>
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
    <h1 class="slogan"> Votre avenir commence ici !</h1>
  </section>

  <section class="section">
    <h2 class="heading-4">Ajouter une offre</h2>
    <div class="w-form">
      <form id="email-form" name="email-form" data-name="Email Form" method="get" data-wf-page-id="67c038fa0fbf3721b579cd1d" data-wf-element-id="2b8a853b-7f0b-5137-ddc7-ea3cb87ac0e5">
        <textarea required="" placeholder="Description du stage" maxlength="5000" id="field" name="field" data-name="Field" class="textarea w-input"></textarea>
        <label for="email" class="field-label-6">Intitulé</label>
        <input class="text-field-5 w-input" maxlength="256" name="email" data-name="Email" placeholder="" type="email" id="email" required="">
        <label class="field-label-7">Localisation</label>
        <input class="text-field-5 w-input" maxlength="256" name="email-4" data-name="Email 4" placeholder="" type="email" id="email-4" required="">
        <label class="field-label-8">Dates du stage/alternance</label>
        <input class="text-field-5 w-input" maxlength="256" name="email-3" data-name="Email 3" placeholder="" type="email" id="email-3" required="">
        <label class="field-label-9">Gratification</label>
        <input class="text-field-5 w-input" maxlength="256" name="email-2" data-name="Email 2" placeholder="" type="email" id="email-2" required="">
        <input type="submit" data-wait="Please wait..." class="submit-button-3 w-button" value="Publier">
      </form>
    </div>
  </section>

  <footer class="pied-de-page">
    <div class="w-layout-hflex contacts">
      <img loading="lazy" src="images/instagram.svg" alt="" class="instagram">
      <img loading="lazy" src="images/twitter.svg" alt="" class="twitter">
      <img loading="lazy" src="images/linkedin.svg" alt="" class="linkedin">
      <img loading="lazy" src="images/facebook.svg" alt="" class="facebook">
      <img loading="lazy" src="images/youtube.svg" alt="" class="image-34">
    </div>
    <div class="mention-l-gales">© 2025 StageHorizon | Inc. Tous droits réservés CGU</div>
  </footer>
  <script src="js/script.js" defer></script>

</body>

</html>
