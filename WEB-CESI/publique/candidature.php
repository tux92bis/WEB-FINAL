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
                
                // Création de l'utilisateur (sans hachage)
                $userId = $userModel->createUser([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'mot_de_passe' => $password, // Stockage en clair
                    'role' => strtolower($statut),
                    'cv_path' => $cvPath
                ]);
                
                $success = "Compte créé avec succès!";
                // Redirection après 3 secondes
                header("Refresh: 3; url=connexion.php");
            }
        } catch (Exception $e) {
            $error = "Erreur lors de la création du compte: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr" data-wf-page="67bf1b3b07f212818b80ddf5" data-wf-site="67b49e8f9c9f8a910dad1bec">
<head>
  <meta charset="utf-8">
  <title>Création de compte</title>
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/stage-horizon.css" rel="stylesheet" type="text/css">
  <style>
    .error { color: red; margin: 10px 0; }
    .success { color: green; margin: 10px 0; }
    #error { display: none; }
  </style>
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
        <nav class="navigation">
          <a href="accueil.php" class="a">Accueil</a>
          <a href="favoris.php" class="favoris">Favoris</a>
          <a href="candidature.php" class="favoris w--current">Candidatures</a>
          <a href="entreprise.php" class="favoris">Entreprises</a>
        </nav>
        <div class="w-nav-button">
          <div data-hover="false" data-delay="50" class="w-dropdown">
            <div class="compte w-dropdown-toggle">
              <div class="w-icon-dropdown-toggle"></div>
              <div>Compte</div>
            </div>
            <nav class="w-dropdown-list">
              <a href="creer-offre.php" class="dropdown-link w-dropdown-link">Ajouter une entreprise</a>
              <a href="ajout-utilisateur.php" class="dropdown-link-2 w-dropdown-link">Ajouter un utilisateur</a>
              <a href="creer-offre.php" class="dropdown-link-3 w-dropdown-link">Ajouter une offre</a>
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

  <section class="creation-compte">
    <h2 class="heading-3">Créer un compte</h2>
    
    <?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    
    <div class="form-block-2 w-form">
      <form id="email-form" name="email-form" method="post" enctype="multipart/form-data">
        <label for="nom" class="field-label">Nom</label>
        <input class="text-field-2 w-input" maxlength="256" name="nom" placeholder="Dupont" type="text" id="nom" required
               value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">

        <label for="prenom" class="field-label">Prénom</label>
        <input class="text-field-2 w-input" maxlength="256" name="prenom" placeholder="Jean" type="text" id="prenom" required
               value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>">

        <label for="email" class="field-label">Adresse mail</label>
        <input class="text-field-2 w-input" maxlength="256" name="email" placeholder="exemple@viacesi.fr" type="email" id="email" required
               value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">

        <label for="password" class="field-label">Mot de passe</label>
        <input class="text-field-2 w-input" maxlength="256" name="password" placeholder="monmotdepasse123" type="password" id="password" required>

        <label for="confirm-password" class="field-label">Confirmer le mot de passe</label>
        <input class="text-field-2 w-input" maxlength="256" name="confirm-password" placeholder="monmotdepasse123" type="password" id="confirm-password" required>
        
        <div id="error" class="error">
          <span id="errorText">Les mots de passe saisis ne correspondent pas. Veuillez vérifier et réessayer.</span>
        </div>

        <label class="radio-button-field w-radio">
          <input type="radio" id="tuteur" name="statut" class="w-radio-input" value="Tuteur" 
                 <?= (isset($_POST['statut']) && $_POST['statut'] === 'Tuteur') ? 'checked' : '' ?>>
          <span class="w-form-label">Tuteur</span>
        </label>

        <label class="radio-button-field-2 w-radio">
          <input type="radio" name="statut" id="etudiant" class="w-radio-input" value="Etudiant"
                 <?= (isset($_POST['statut']) && $_POST['statut'] === 'Etudiant') ? 'checked' : '' ?>>
          <span class="w-form-label">Étudiant</span>
        </label>

        <label class="radio-button-field-3 w-radio">
          <input type="radio" id="admin" name="statut" class="w-radio-input" value="Admin"
                 <?= (isset($_POST['statut']) && $_POST['statut'] === 'Admin') ? 'checked' : '' ?>>
          <span class="w-form-label">Admin</span>
        </label>

        <div class="depot">
          <p class="label1">Déposez votre CV</p>
          <input type="file" id="fileInput" name="cv" accept=".pdf,.doc,.docx" required>
          <small>Formats acceptés: PDF, DOC, DOCX (max 2MB)</small>
        </div>

        <input type="submit" data-wait="Veuillez patienter..." class="submit-button w-button" value="Créer">
      </form>
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
    <div class="mention-l-gales">© 2025 StageHorizon | Inc. Tous droits réservés CGU</div>
  </footer>

  <script>
  // Validation côté client
  document.getElementById('email-form').addEventListener('submit', function(e) {
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm-password').value;
      const errorElement = document.getElementById('error');
      
      if (password !== confirmPassword) {
          e.preventDefault();
          errorElement.style.display = 'block';
      } else {
          errorElement.style.display = 'none';
      }
      
      // Validation du fichier
      const fileInput = document.getElementById('fileInput');
      if (fileInput.files.length > 0) {
          const file = fileInput.files[0];
          const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
          const maxSize = 2 * 1024 * 1024; // 2MB
          
          if (!validTypes.includes(file.type)) {
              e.preventDefault();
              alert('Seuls les fichiers PDF, DOC et DOCX sont acceptés');
          }
          
          if (file.size > maxSize) {
              e.preventDefault();
              alert('Le fichier est trop volumineux (max 2MB)');
          }
      }
  });
  </script>
</body>
</html>