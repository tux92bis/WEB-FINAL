<?php
// Supprimer le session_start() ici car il est déjà appelé dans index.php

if ($utilisateur) {
    $_SESSION['utilisateur'] = [
        'id' => $utilisateur['id_utilisateur'],
        'email' => $utilisateur['email']
        // autres informations nécessaires
    ];
    header('Location: accueil.php');
    exit();
}