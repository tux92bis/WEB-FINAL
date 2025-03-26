<!DOCTYPE html>
<html lang="fr" data-wf-page="67bc967e0972095bf8851d61" data-wf-site="67b49e8f9c9f8a910dad1bec">

<head>
  <meta charset="utf-8">
  <title>Créer offre</title>
  <meta content="Créer offre" property="og:title">
  <meta content="Créer offre" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/stage-horizon.css" rel="stylesheet" type="text/css">
  <script>
    !function (o, c) { 
      var n = c.documentElement, t = " w-mod-"; 
      n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && 
      (n.className += t + "touch") 
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
          <a href="accueil.html" aria-current="page" class="a w--current">Accueil</a>
          <a href="favoris.html" class="favoris">Favoris</a>
          <a href="offre.html" class="favoris">Offres de stage</a>
          <a href="candidature.html" class="favoris">Candidatures</a>
          <a href="entreprise.html" class="favoris">Entreprises</a>
        </nav>
        <div  class="w-nav-button">
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
    <h1 class="slogan">Votre avenir commence ici !</h1>
  </section>

  <section class="creer-entreprise">
    <h2>Ajouter votre entreprise</h2>
    <div class="w-layout-layout wf-layout-layout">

      <div class="w-layout-cell">
        <div class="w-form">
          <form id="email-form-1" name="email-form" method="get" class="form-2">
            <label for="name">Nom :</label>
            <input class="text-field w-input" maxlength="256" name="name" placeholder="Ex: THALES" type="text" id="name" required>
          </form>
        </div>
      </div>

      <div class="w-layout-cell">
        <div class="w-form">
          <form id="email-form-2" name="email-form" method="get" class="form-2">
            <label for="phone">Téléphone :</label>
            <input class="text-field w-input" maxlength="256" name="phone" placeholder="Ex: 0102030405" type="text" id="phone" required>
          </form>
        </div>
      </div>

      <div class="w-layout-cell">
        <div class="w-form">
          <form id="email-form-3" name="email-form" method="get" class="form-2">
            <label for="address">Adresse :</label>
            <input class="text-field w-input" maxlength="256" name="address" placeholder="Ex: 1 rue de l'église" type="text" id="address" required>
          </form>
        </div>
      </div>

      <div class="w-layout-cell">
        <div class="w-form">
          <form id="email-form-4" name="email-form" method="get" class="form-2">
            <label for="siret">N° SIRET :</label>
            <input class="text-field w-input" maxlength="256" name="siret" placeholder="Ex: 0102030405" type="text" id="siret" required>
          </form>
        </div>
      </div>

      <div class="w-layout-cell">
        <div class="w-form">
          <form id="email-form-5" name="email-form" method="get" class="form-2">
            <label for="effectif">Effectif :</label>
            <input class="text-field w-input" maxlength="256" name="effectif" placeholder="Ex: 100" type="text" id="effectif" required>
          </form>
        </div>
      </div>

      <div class="w-layout-cell">
        <div class="w-form">
          <form id="email-form-6" name="email-form" method="get" class="form-2">
            <label for="code-ape">Code APE :</label>
            <input class="text-field w-input" maxlength="256" name="code-ape" placeholder="Ex: 1234Z" type="text" id="code-ape" required>
          </form>
        </div>
      </div>

      <div class="w-layout-cell">
        <div class="w-form">
          <form id="email-form-7" name="email-form" method="get" class="form-2">
            <label for="email">Email :</label>
            <input class="text-field w-input" maxlength="256" name="email" placeholder="Ex: exemple@email.com" type="email" id="email" required>
          </form>
        </div>
      </div>

      <a href="#" class="ajouter w-button">Ajouter</a>
     
    </div>
  </section>
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

