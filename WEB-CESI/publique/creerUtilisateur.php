<?php
session_start();
require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/utilisateur.php';

$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bdd = connexionBDD();
    $userModel = new Utilisateur($bdd);

    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $statut = $_POST['statut'];
    
    if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format d'email invalide";
    } else {
        try {
            if ($userModel->emailExists($email)) {
                $error = "Cet email est déjà utilisé";
            } else {
                $cvPath = '';
                if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../uploads/cv/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $extension = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
                    $filename = uniqid() . '.' . $extension;
                    $cvPath = 'uploads/cv/' . $filename;
                    
                    if (!move_uploaded_file($_FILES['cv']['tmp_name'], $uploadDir . $filename)) {
                        throw new Exception("Erreur lors de l'upload du CV");
                    }
                }
                $userId = $userModel->createUser([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'mot_de_passe' => $password,
                    'role' => strtolower($statut),
                    'cv_path' => $cvPath
                ]);
                
                $success = "Compte créé avec succès!";
                header("Refresh: 3; url=connexion.php");
            }
        } catch (Exception $e) {
            $error = "Erreur lors de la création du compte: " . $e->getMessage();
        }
    }
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
        <img src="images/logo-site.png" loading="lazy" width="100"
          sizes="(max-width: 479px) 71vw, 112.99479675292969px" alt=""
          srcset="images/logo-site-p-500.png 500w, images/logo-site.png 577w">
      </a>
      <div class="menu w-container">

        <nav  class="navigation">
          <a href="accueil.php" aria-current="page" class="a w--current">Accueil</a>
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
    <h1 class="slogan">Votre avenir commence ici !</h1>
  </section>

  <section class="section">
    <img src="images/generic-avatar.svg" loading="lazy" alt="" class="image-4">
    <img src="images/map-pin.png" loading="lazy" alt="" class="localisation">
    <div class="text-block-2">Localisation</div>
    <h2 class="titre-offre">Nom de l&#x27;entreprise - Titre de l&#x27;offre</h2>

    <div class="w-form">
      <form id="email-form" name="email-form" data-name="Email Form" method="get"
        data-wf-page-id="67bf248277d7dea90311558a" data-wf-element-id="46a362b6-90c0-930a-d3d7-be446062f6ac">

        <label for="name" class="nom">Prénom</label>
        <input class="text-field-4 w-input" maxlength="256" name="name" data-name="Name" 
          placeholder="Jean" type="text" id="name" required="">
        
          <label class="telephone">Téléphone</label>
          <input class="telephone-label w-input" maxlength="256" name="name-3" data-name="Name 3"
            placeholder="0102030405" type="text" id="name-3" required="">

        <label for="name-5" class="field-label-3">Nom</label>
        <input class="text-field-4 w-input" maxlength="256" name="name-5" data-name="Name 5" 
          placeholder="Dupont" type="text" id="name-5" required="">

        <label class="field-label-4">Adresse mail</label>
        <input class="text-field-4 w-input" maxlength="256" name="name-4" data-name="Name 4" 
          placeholder="Exemple@viacesi.fr" type="text" id="name-4" required="">

        <label class="w-checkbox checkbox-field-2">
          <input type="checkbox" id="checkbox" name="checkbox" data-name="Checkbox" required="" class="w-checkbox-input">
          <span class="w-form-label">Je certifie être majeur, avoir renseigné des informations exactes</span>
        </label>

        <label class="w-checkbox checkbox-field-2">
          <input type="checkbox" id="checkbox-2" name="checkbox-2" data-name="Checkbox 2" required="" class="w-checkbox-input">
          <span class="w-form-label">J&#x27;autorise le destinataire à stocker et traiter mes informations personnelles dans le cadre de ma candidature</span>
        </label>
        <input type="submit" data-wait="Please wait..." class="button-2 w-button" value="Envoyer">
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
