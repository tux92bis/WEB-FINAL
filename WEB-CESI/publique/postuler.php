<?php
session_start();
require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/offreStage.php';

if (!isset($_GET['id'])) {
  header('Location: accueil.php');
  exit();
}

$bdd = connexionBDD();

$sql = "SELECT o.*, e.nom as nom_entreprise, e.localisation 
        FROM OffreStage o 
        JOIN Entreprise e ON o.id_entreprise = e.id_entreprise 
        WHERE o.id_offre = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$_GET['id']]);
$offre = $stmt->fetch();

if (!$offre) {
  header('Location: accueil.php');
  exit();
}
// [...] (le début de votre fichier postuler.php reste inchangé)

// Traitement du formulaire si soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    // Récupérer l'ID étudiant
    $stmt = $bdd->prepare("SELECT id_etudiant FROM Etudiant WHERE id_utilisateur = ?");
    $stmt->execute([$_SESSION['user']['id_utilisateur']]); // Note: j'ai corrigé la clé de session
    $etudiant = $stmt->fetch();

    if ($etudiant) {
      // MODIFICATION ICI - Nouveau code d'insertion avec fichiers
      $stmt = $bdd->prepare("INSERT INTO Candidature 
                            (id_etudiant, id_offre, date_candidature, cv, lettre_motivation) 
                            VALUES (?, ?, CURRENT_TIMESTAMP, ?, ?)");

      // Traitement des fichiers uploadés
      $cvPath = uploadFile($_FILES['cv'], 'cv');
      $lmPath = uploadFile($_FILES['lettre_motivation'], 'lm');

      $stmt->execute([
          $etudiant['id_etudiant'], 
          $_GET['id'],
          $cvPath,
          $lmPath
      ]);

      $_SESSION['success'] = "Votre candidature a été envoyée avec succès !";
      header('Location: accueil.php');
      exit();
    }
  } catch (Exception $e) {
    $error = "Une erreur est survenue lors de l'envoi de votre candidature: " . $e->getMessage();
  }
}

// AJOUTER LA FONCTION UPLOADFILE À LA FIN DU FICHIER
function uploadFile($file, $prefix) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $prefix . '_' . uniqid() . '.' . $ext;
        $uploadDir = __DIR__ . '/../uploads/'; // Chemin relatif au dossier parent
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        move_uploaded_file($file['tmp_name'], $uploadDir . $filename);
        return 'uploads/' . $filename; // Chemin relatif pour le stockage en BDD
    }
    return null;
}

?>

<html lang="fr" data-wf-page="67bf248277d7dea90311558a" data-wf-site="67b49e8f9c9f8a910dad1bec">

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
      var n = c.documentElement, t = " w-mod-";
      n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) &&
        (n.className += t + "touch");
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
    <img src="images/generic-avatar.svg" loading="lazy" alt="" class="image-4">


    <div class="form-container">
    <h4><?= htmlspecialchars($offre['nom_entreprise']) ?> - <?= htmlspecialchars($offre['titre']) ?>
    </h4>
      <form id="email-form" name="email-form" method="POST" enctype="multipart/form-data">
        <div class="form-grid">
          <div class="form-row">
            <label for="name" class="nom">Prénom</label>
            <input class="text-field-4 w-input" maxlength="256" name="name" data-name="Name" placeholder="Jean" type="text"
            id="name" required="">
            <label for="name-5" class="field-label-3">Nom</label>
            <input class="text-field-4 w-input" maxlength="256" name="name-5" data-name="Name 5" placeholder="Dupont"
            type="text" id="name-5" required="">
          </div>
        </div>
        <div class="form-grid">
          <div class="form-row">
            <label class="field-label-4">Téléphone</label>
            <input class="telephone-label w-input" maxlength="256" name="name-3" data-name="Name 3" placeholder="0102030405"
            type="text" id="name-3" required="">
            <label class="field-label-4">Adresse mail</label>
            <input class="text-field-4 w-input" maxlength="256" name="name-4" data-name="Name 4"
            placeholder="Exemple@viacesi.fr" type="text" id="name-4" required="">
          </div>
        </div>
        <div class="form-grid">
          <div class="form-row">
            <form method="post" enctype="multipart/form-data">
              <input type="file" name="cv" accept=".pdf,.doc,.docx">
              <input type="file" name="lettre_motivation" accept=".pdf,.doc,.docx">
              <button type="submit" class="button-2 w-button">Postuler</button>
            </form>         
  
          </div>
        </div>


        <label class="w-checkbox checkbox-field-2">
          <input type="checkbox" id="checkbox" name="checkbox" data-name="Checkbox" required=""
            class="w-checkbox-input">
          <span class="w-form-label">Je certifie être majeur, avoir renseigné des informations exactes</span>
        </label>

        <label class="w-checkbox checkbox-field-2">
          <input type="checkbox" id="checkbox-2" name="checkbox-2" data-name="Checkbox 2" required=""
            class="w-checkbox-input">
          <span class="w-form-label">J&#x27;autorise le destinataire à stocker et traiter mes informations personnelles
            dans le cadre de ma candidature</span>
        </label>

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