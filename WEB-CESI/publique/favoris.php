<?php
session_start();

require_once __DIR__ . '/../config/BDD.php';
require_once __DIR__ . '/../modèles/offreStage.php';
require_once __DIR__ . '/../modèles/favoris.php';
require_once __DIR__ . '/../modèles/entreprise.php';

$bdd = connexionBDD();
$favoris = [];

error_log("Session dans favoris.php : " . print_r($_SESSION, true));

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_utilisateur'])) {
  header('Location: connexion.php');
  exit();
}

// Récupération de l'ID étudiant
$stmt = $bdd->prepare("SELECT id_etudiant FROM Etudiant WHERE id_utilisateur = ?");
$stmt->execute([$_SESSION['user']['id_utilisateur']]);
$etudiant = $stmt->fetch();

error_log("ID étudiant trouvé : " . print_r($etudiant, true));

if ($etudiant) {
  $sql = "SELECT o.*, e.nom as nom_entreprise, e.description as description_entreprise,
            o.date_debut as date_de_debut, o.date_fin as date_de_fin, o.type
            FROM OffreStage o 
            INNER JOIN Favoris f ON o.id_offre = f.id_offre 
            INNER JOIN Entreprise e ON o.id_entreprise = e.id_entreprise 
            WHERE f.id_etudiant = :id_etudiant";

  try {
    $stmt = $bdd->prepare($sql);
    $stmt->execute([':id_etudiant' => $etudiant['id_etudiant']]);
    $favoris = $stmt->fetchAll(PDO::FETCH_ASSOC);

    error_log("Requête SQL exécutée : " . $sql);
    error_log("Paramètres : id_etudiant = " . $etudiant['id_etudiant']);
    error_log("Nombre de favoris trouvés : " . count($favoris));
    error_log("Favoris : " . print_r($favoris, true));

    foreach ($favoris as &$offre) {
      if (!empty($offre['date_de_debut']) && !empty($offre['date_de_fin'])) {
        $debut = new DateTime($offre['date_de_debut']);
        $fin = new DateTime($offre['date_de_fin']);
        $duree = $debut->diff($fin);
        $offre['duree'] = $duree->format('%m mois');
      } else {
        $offre['duree'] = 'Durée non spécifiée';
      }
    }
    unset($offre);

  } catch (PDOException $e) {
    error_log("Erreur SQL dans favoris.php: " . $e->getMessage());
    $favoris = [];
  }
} else {
  error_log("Aucun étudiant trouvé pour l'utilisateur ID: " . $_SESSION['user']['id_utilisateur']);
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
              <a href="creerOffre.php" class="dropdown-link w-dropdown-link">Ajouter une offre</a>
              <a href="creerUtilisateur.php" class="dropdown-link-2 w-dropdown-link">Ajouter un utilisateur</a>
              <a href="creerEntreprise.php" class="dropdown-link-3 w-dropdown-link">Ajouter une entreprise</a>
            </nav>
          </div><img src="images/generic-avatar.svg" loading="lazy" width="36" alt="" class="image">
        </div>
      </div>
    </div>
  </header>
  <div class="w-layout-grid grid">
    <?php if (!empty($favoris)): ?>
      <?php foreach ($favoris as $offre): ?>
        <div class="w-layout-cell cell-5">
          <h2 class="heading-2"><?= htmlspecialchars($offre['nom_entreprise']) ?></h2>
          <img src="images/bandeau-offre.png" loading="lazy" alt="" class="image-5">
          <h3><?= htmlspecialchars($offre['titre']) ?></h3>
          <p class="paragraph"><?= htmlspecialchars($offre['description']) ?></p>

          <div class="offre-details">
            <p><strong>Type:</strong> <?= htmlspecialchars($offre['type']) ?></p>
            <p><strong>Durée:</strong> <?= htmlspecialchars($offre['duree']) ?></p>
            <p><strong>Rémunération:</strong> <?= htmlspecialchars($offre['base_remuneration']) ?>€</p>
            <p><strong>Domaine:</strong> <?= htmlspecialchars($offre['mineure']) ?></p>
          </div>

          <a href="postuler.php?id=<?= $offre['id_offre'] ?>" class="button-2 w-button">Postuler</a>
          <button class="btn" onclick="supprimerFavori(<?= $offre['id_offre'] ?>)">
            <svg viewBox="0 0 15 17.5" height="17.5" width="15" xmlns="http://www.w3.org/2000/svg" class="icon">
              <path transform="translate(-2.5 -1.25)"
                d="M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z"
                id="Fill"></path>
            </svg>
          </button>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="no-favoris">Vous n'avez pas encore de favoris</p>
    <?php endif; ?>
  </div>

  <footer class="pied-de-page">
    <div class="w-layout-hflex contacts"><img loading="lazy" src="images/instagram.svg" alt="" class="instagram"><img
        loading="lazy" src="images/twitter.svg" alt="" class="twitter"><img loading="lazy" src="images/linkedin.svg"
        alt="" class="linkedin"><img loading="lazy" src="images/facebook.svg" alt="" class="facebook"><img
        loading="lazy" src="images/youtube.svg" alt="" class="image-26"></div>
    <div class="mention-l-gales">© 2025 StageHorizon | Inc. Tous droits réservés CGU</div>
  </footer>
  <script src="js/script.js" defer></script>
  <script>
    function supprimerFavori(idOffre) {
      fetch('../contrôlleurs/ajouterFavori.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id_offre=' + idOffre
      })
        .then(response => {
          if (response.ok) {
            location.reload();
          } else {
            throw new Error('Erreur lors de la suppression du favori');
          }
        })
        .catch(error => {
          console.error('Erreur:', error);
          alert('Erreur lors de la suppression du favori');
        });
    }
  </script>
</body>

</html>