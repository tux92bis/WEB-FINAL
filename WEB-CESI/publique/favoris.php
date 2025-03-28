
<?php
session_start();
require_once __DIR__ . '/../config/BDD.php';

$error = '';
$success = '';

try {
    $bdd = connexionBDD();
    
    if (!isset($_SESSION['user_id'])) {
        header('Location: connexion.php');
        exit();
    }

    $stmt = $bdd->prepare("
        SELECT o.*, e.nom as entreprise_nom, e.logo_path
        FROM Offre o
        INNER JOIN Favoris f ON o.id = f.offre_id 
        INNER JOIN Entreprise e ON o.entreprise_id = e.id
        WHERE f.utilisateur_id = :user_id
        ORDER BY f.date_ajout DESC
    ");
    
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $favoris = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (isset($_POST['remove_favori'])) {
        $offre_id = $_POST['offre_id'];
        
        $stmt = $bdd->prepare("
            DELETE FROM Favoris 
            WHERE utilisateur_id = :user_id 
            AND offre_id = :offre_id
        ");
        
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':offre_id' => $offre_id
        ]);
        
        $success = "Offre retirée des favoris";
        header("Refresh: 1");
    }

} catch (Exception $e) {
    $error = "Erreur lors de la récupération des favoris: " . $e->getMessage();
}
?>

<html lang="fr" data-wf-page="67b5bf1849f940e792c2855e" data-wf-site="67b49e8f9c9f8a910dad1bec">

<head>
  <meta charset="utf-8">
  <title>Favoris</title>
  <meta content="Favoris" property="og:title">
  <meta content="Favoris" property="twitter:title">
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
    <h1 class="slogan"> Votre avenir commence ici !</h1>
    <div class="search-bar-container">
      <form id="search-form" method="get" action="#">
        <input type="text" id="search" name="search" placeholder="Rechercher..." class="search-input">
        <button type="submit" class="search-button">🔍</button>
      </form>
    </div>
  </section>
  <div id="w-node-_38b87cf2-cd7e-10d0-1a13-de02a947c1bc-0dad1bf7" class="liked-list wf-layout-layout">
    <div class="w-layout-cell cell-5">
      <h2 class="heading-2">Entreprise</h2><img src="images/bandeau-offre.png" loading="lazy"  alt=""
        class="image-5">
      <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
        elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero
        vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique
        posuere.</p>
      <a href="#" class="button-2 w-button">Postuler</a>
      <img src="images/generic-avatar.svg" loading="lazy" width="37" alt="" class="image-4">
      <button class="btn">
        <svg viewBox="0 0 15 17.5" height="17.5" width="15" xmlns="http://www.w3.org/2000/svg" class="icon">
        <path transform="translate(-2.5 -1.25)" d="M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z" id="Fill"></path>
        </svg>
      </button>
    </div>
    <div class="w-layout-cell cell-5">
      <h2 class="heading-2">Entreprise</h2><img src="images/bandeau-offre.png" loading="lazy" alt=""
        class="image-5">
      <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
        elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero
        vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique
        posuere.</p>
      <a href="#" class="button-2 w-button">Postuler</a>
      <button class="btn">
        <svg viewBox="0 0 15 17.5" height="17.5" width="15" xmlns="http://www.w3.org/2000/svg" class="icon">
        <path transform="translate(-2.5 -1.25)" d="M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z" id="Fill"></path>
        </svg>
      </button>
      <img src="images/generic-avatar.svg" loading="lazy" width="37" alt="" class="image-4">
    </div>
    <div class="w-layout-cell cell-5">
      <h2 class="heading-2">Entreprise</h2><img src="images/bandeau-offre.png" loading="lazy" alt=""
        class="image-5">
      <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
        elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero
        vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique
        posuere.</p>
      <a href="#" class="button-2 w-button">Postuler</a>
      <button class="btn">
        <svg viewBox="0 0 15 17.5" height="17.5" width="15" xmlns="http://www.w3.org/2000/svg" class="icon">
        <path transform="translate(-2.5 -1.25)" d="M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z" id="Fill"></path>
        </svg>
      </button>
      <img src="images/generic-avatar.svg" loading="lazy" width="37" alt="" class="image-4">
    </div>
    <div class="w-layout-cell cell-5">
      <h2 class="heading-2">Entreprise</h2><img src="images/bandeau-offre.png" loading="lazy" alt=""
        class="image-5">
      <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
        elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero
        vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique
        posuere.</p>
      <a href="#" class="button-2 w-button">Postuler</a>
      <button class="btn">
        <svg viewBox="0 0 15 17.5" height="17.5" width="15" xmlns="http://www.w3.org/2000/svg" class="icon">
        <path transform="translate(-2.5 -1.25)" d="M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z" id="Fill"></path>
        </svg>
      </button>
      <img src="images/generic-avatar.svg" loading="lazy" width="37" alt="" class="image-4">
    </div>
  </div>
  <div class="pagination">
    <a href="#">&laquo;</a>
    <a href="#">1</a>
    <a class="active" href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
    <a href="#">5</a>
    <a href="#">6</a>
    <a href="#">&raquo;</a>
  </div>
  <footer class="pied-de-page">
    <div class="w-layout-hflex contacts"><img src="images/instagram.svg" loading="lazy" alt="" class="instagram"><img
        src="images/twitter.svg" loading="lazy" alt="" class="twitter"><img src="images/linkedin.svg" loading="lazy"
        alt="" class="linkedin"><img src="images/facebook.svg" loading="lazy" alt="" class="facebook"><img
        src="images/youtube.svg" loading="lazy" alt="" class="image-2"></div>
    <div class="mention-l-gales">© 2025 StageHorizon | Inc. Tous droits réservés CGU</div>
  </footer>
  <script src="js/script.js" defer></script>
</body>

</html>