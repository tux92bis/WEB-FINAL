<?php
// Définir BASE_URL si ce n'est pas déjà fait
if (!defined('BASE_URL')) {
  define('BASE_URL', '/');
}

echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
?>
<!DOCTYPE html>
<html lang="fr" data-wf-page="67b49e8f9c9f8a910dad1bf7" data-wf-site="67b49e8f9c9f8a910dad1bec">

<head>
  <meta charset="utf-8">
  <title>Stage-Horizon</title>
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="<?= BASE_URL ?>css/normalize.css" rel="stylesheet" type="text/css">
  <link href="<?= BASE_URL ?>css/style.css" rel="stylesheet" type="text/css">
  <link href="<?= BASE_URL ?>css/stage-horizon.css" rel="stylesheet" type="text/css">
  <script>!function (o, c) { var n = c.documentElement, t = " w-mod-"; n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch") }(window, document);</script>
  <img src="/images/logo-site.png" loading="lazy" width="100" sizes="(max-width: 479px) 71vw, 112.99479675292969px"
    alt="" srcset="/images/logo-site-p-500.png 500w, /images/logo-site.png 577w">
</head>

<body class="body">
  <header>
    <div data-animation="default" data-collapse="all" data-duration="400" data-easing="ease" data-easing2="ease"
      role="banner" class="navbar w-nav">
      <a href="#" class="w-nav-brand">
        <img src="/images/logo-site.png" loading="lazy" width="100"
          sizes="(max-width: 479px) 71vw, 112.99479675292969px" alt=""
          srcset="/images/logo-site-p-500.png 500w, /images/logo-site.png 577w">
      </a>
      <div class="menu w-container">

        <nav class="navigation">
          <a href="accueil.html" aria-current="page" class="a w--current">Accueil</a>
          <a href="favoris.html" class="favoris">Favoris</a>
          <a href="offre.html" class="favoris">Offres de stage</a>
          <a href="candidature.html" class="favoris">Candidatures</a>
          <a href="entreprise.html" class="favoris">Entreprises</a>
        </nav>
        <div class="w-nav-button">
          <div data-hover="false" data-delay="50" class="w-dropdown">
            <div class="compte w-dropdown-toggle">
              <div class="w-icon-dropdown-toggle"></div>
              <div> Compte</div>
            </div>
            <nav class="w-dropdown-list">
              <a href="creer-offre.html" class="dropdown-link w-dropdown-link">Ajouter une offre</a>
              <a href="candidature2.html" class="dropdown-link-2 w-dropdown-link">Ajouter un utilisateur</a>
              <a href="creer-offre2.html" class="dropdown-link-3 w-dropdown-link">Ajouter une entreprise</a>
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
  <div class="w-layout-vflex flex-block"></div>
  <aside class="filtres w-form">
    <form id="email-form" name="email-form" data-name="Email Form" method="get" class="form"
      data-wf-page-id="67b49e8f9c9f8a910dad1bf7" data-wf-element-id="2d372f55-fc3f-5eaf-7a6d-1992c8428c09">

      <h4>Filtrer les offres</h4>

      <!-- Boutons radio -->
      <fieldset>
        <legend>Type de contrat</legend>
        <label class="w-radio">
          <input type="radio" id="radio-alternance" name="Type" class="w-form-formradioinput w-radio-input"
            value="Alternance">
          <span class="w-form-label">Alternance</span>
        </label>

        <label class="w-radio">
          <input type="radio" id="radio-stage" name="Type" class="w-form-formradioinput w-radio-input" value="Stage">
          <span class="w-form-label">Stage</span>
        </label>
      </fieldset>

      <!-- Cases à cocher -->
      <fieldset>
        <legend>Domaines</legend>
        <label class="w-checkbox">
          <input type="checkbox" id="checkbox-btp" name="checkbox-btp"
            class="w-form-formcheckboxinput w-checkbox-input">
          <span class="w-form-label">BTP</span>
        </label>

        <label class="w-checkbox">
          <input type="checkbox" id="checkbox-s3e" name="checkbox-s3e"
            class="w-form-formcheckboxinput w-checkbox-input">
          <span class="w-form-label">S3E</span>
        </label>

        <label class="w-checkbox">
          <input type="checkbox" id="checkbox-informatique" name="checkbox-informatique"
            class="w-form-formcheckboxinput w-checkbox-input">
          <span class="w-form-label">Informatique</span>
        </label>

        <label class="w-checkbox">
          <input type="checkbox" id="checkbox-generaliste" name="checkbox-generaliste"
            class="w-form-formcheckboxinput w-checkbox-input">
          <span class="w-form-label">Généraliste</span>
        </label>
      </fieldset>

    </form>
  </aside>


  <div id="w-node-_38b87cf2-cd7e-10d0-1a13-de02a947c1bc-0dad1bf7" class="w-layout-layout offres wf-layout-layout">
    <div class="w-layout-cell cell">
      <h2 class="heading-2">Entreprise</h2><img src="images/bandeau-offre.png" loading="lazy" alt="" class="image-5">
      <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
        elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero
        vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique
        posuere.</p>
      <a href="#" class="button-2 w-button">Postuler</a>
      <!-- From Uiverse.io by Jimdrer -->
      <input type="checkbox" id="checkbox" />
      <label for="checkbox" class="toggle">
        <div class="bars" id="bar1"></div>
        <div class="bars" id="bar2"></div>
        <div class="bars" id="bar3"></div>
      </label>

      <button class="favoris-btn">☆</button>
      <img src="images/generic-avatar.svg" loading="lazy" width="37" alt="" class="image-4">
    </div>
    <div class="w-layout-cell cell">
      <h2 class="heading-2">Entreprise</h2><img src="images/bandeau-offre.png" loading="lazy" alt="" class="image-5">
      <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
        elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero
        vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique
        posuere.</p>
      <a href="#" class="button-2 w-button">Postuler</a>
      <button class="favoris-btn">☆</button>
      <img src="images/generic-avatar.svg" loading="lazy" width="37" alt="" class="image-4">
    </div>
    <div class="w-layout-cell cell">
      <h2 class="heading-2">Entreprise</h2><img src="images/bandeau-offre.png" loading="lazy" alt="" class="image-5">
      <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
        elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero
        vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique
        posuere.</p>
      <a href="offre.html" class="button-2 w-button">Postuler</a>
      <button class="favoris-btn">☆</button>
      <img src="images/generic-avatar.svg" loading="lazy" width="37" alt="" class="image-4">
    </div>
    <div class="w-layout-cell cell">
      <h2 class="heading-2">Entreprise</h2><img src="images/bandeau-offre.png" loading="lazy" alt="" class="image-5">
      <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
        elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero
        vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique
        posuere.</p>
      <a href="#" class="button-2 w-button">Postuler</a>
      <button class="favoris-btn">☆</button>
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