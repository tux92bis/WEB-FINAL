<?php
session_start();
require_once(dirname(__DIR__) . '/config/BDD.php');
require_once(dirname(__DIR__) . '/contrôlleurs/authentification.php');

$bdd = connexionBDD();
$auth = new Authentification($bdd);
$erreur = '';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($auth->connexion($_POST['email'], $_POST['mot_de_passe'])) {
        header('Location: accueil.php');
        exit();
    }
    $erreur = 'Email ou mot de passe incorrect';
}
?>


<!DOCTYPE html>
<html lang="fr" data-wf-page="67bf0b02b89e8d9fc73fa4f9" data-wf-site="67b49e8f9c9f8a910dad1bec">

<head>
    <meta charset="utf-8">
    <title>Connexion - Stage Horizon</title>
    <meta content="offre" property="og:title">
    <meta content="offre" property="twitter:title">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="css/normalize.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/stage-horizon.css" rel="stylesheet" type="text/css">
    <script>!function (o, c) { var n = c.documentElement, t = " w-mod-"; n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch") }(window, document);</script>
</head>

<body class="body-2">
    <div data-animation="default" data-collapse="all" data-duration="400" data-easing="ease" data-easing2="ease"
        role="banner" class="navbar w-nav">
        <a href="#" class="w-nav-brand"><img width="113" sizes="(max-width: 479px) 58vw, 112.99479675292969px" alt=""
                src="images/logo-site.png" loading="lazy"
                srcset="images/logo-site-p-500.png 500w, images/logo-site.png 577w"></a>
        <div class="menu w-container">
            <nav class="w-nav-menu"></nav>
        </div>
    </div>

    <section class="bandeau">
        <h1 class="slogan"> Votre avenir commence ici !</h1>
    </section>

    <div class="login-wrapper">
        <div class="login-container">
            <h2>Connexion à STAGE HORIZON</h2>
            <?php if ($erreur): ?>
                <div style="color: red; margin-bottom: 10px; text-align: center;">
                    <?= htmlspecialchars($erreur) ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="email" placeholder="Adresse email" required>
                <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>

    <footer class="pied-de-page">
        <div class="w-layout-hflex contacts"><img loading="lazy" src="images/instagram.svg" alt=""
                class="instagram"><img loading="lazy" src="images/twitter.svg" alt="" class="twitter"><img
                loading="lazy" src="images/linkedin.svg" alt="" class="linkedin"><img loading="lazy"
                src="images/facebook.svg" alt="" class="facebook"><img loading="lazy" src="images/youtube.svg" alt=""
                class="image-26"></div>
        <div class="mention-l-gales">© 2025 StageHorizon | Inc. Tous droits réservés CGU</div>
    </footer>
</body>

</html>