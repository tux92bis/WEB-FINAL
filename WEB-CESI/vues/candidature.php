<!DOCTYPE html>
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
    !function(o, c) {
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

  
  <section class="creation-compte">
    <h2 class="heading-3">Créer un compte</h2>
    
    <div class="form-block-2 w-form">
      <form id="email-form" name="email-form" data-name="Email Form" method="get"
        data-wf-page-id="67bf1b3b07f212818b80ddf5" data-wf-element-id="a9358edd-6cfa-5ee4-470c-7258d33aad77">
        
        <label for="nom" class="field-label">Nom</label>
        <input class="text-field-2 w-input" maxlength="256" name="nom" data-name="Nom" placeholder="Dupont" type="text" id="nom" required="">

        <label for="prenom" class="field-label">Prénom</label>
        <input class="text-field-2 w-input" maxlength="256" name="prenom" data-name="Prenom" placeholder="Jean" type="text" id="prenom" required="">

        <label for="email" class="field-label">Adresse mail</label>
        <input class="text-field-2 w-input" maxlength="256" name="email" data-name="Email" placeholder="exemple@viacesi.fr" type="email" id="email" required="">

        <label for="password" class="field-label">Mot de passe</label>
        <input class="text-field-2 w-input" maxlength="256" name="password" data-name="Password" placeholder="monmotdepasse123" type="password" id="password" required="">

        <label for="confirm-password" class="field-label">Confirmer le mot de passe</label>
        <input class="text-field-2 w-input" maxlength="256" name="confirm-password" data-name="Confirm Password" placeholder="monmotdepasse123" type="password" id="confirm-password" required="">
        <div id="error" class=" error">
          <span id="errorText" for=""> Les mots de passe saisis ne correspondent pas. Veuillez vérifier et réessayer. </span>
        </div>
        <label class="radio-button-field w-radio">
          <input type="radio" data-name="statut" id="tuteur" name="statut" class="w-form-formradioinput w-radio-input" value="Tuteur">
          <span class="w-form-label">Tuteur</span>
        </label>

        <label class="radio-button-field-2 w-radio">
          <input type="radio" name="statut" id="etudiant" data-name="statut" class="w-form-formradioinput w-radio-input" value="Etudiant">
          <span class="w-form-label">Étudiant</span>
        </label>

        <label class="radio-button-field-3 w-radio">
          <input type="radio" data-name="statut" id="admin" name="statut" class="w-form-formradioinput w-radio-input" value="Admin">
          <span class="w-form-label">Admin</span>
        </label>
        <div class="depot">
          <p class="label1">Déposez votre CV</p>
          <input type="file" id="fileInput" name="cv" required>
        </div>



        <input type="submit" data-wait="Please wait..." class="submit-button w-button" value="Créer">
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
    
    <div class="mention-l-gales">
      © 2025 StageHorizon | Inc. Tous droits réservés CGU
    </div>
  </footer>
  <script src="js/script.js" defer></script>

  
</body>

</html>
