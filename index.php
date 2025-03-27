<?php
// Définir le chemin racine de l'application
define('ROOT_PATH', dirname(__DIR__));
define('BASE_URL', '/');

// Activer l'affichage des erreurs pendant le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure la configuration de la base de données
require_once(ROOT_PATH . '/config/database.php');

// Routage
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'accueil';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Charger le contrôleur approprié
require_once(ROOT_PATH . "/controllers/{$controller}Controller.php");
$controllerName = ucfirst($controller) . 'Controller';
$controllerInstance = new $controllerName();
$controllerInstance->$action();