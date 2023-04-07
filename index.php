<?php
// Les messages d'erreurs entre formulaires (qui changent de pages) sont passés par la SESSION
// Nous initialisons donc la SESSION pour toutes les pages du site
session_start();

// On définie des variables globales constants, pouvant être réutilisées partout dans le code
const ROOT = __DIR__; // Répertoire du fichier index.php
const VIEWS = ROOT."/Vues"; // Répertoire où sont situées les vues

// L'application est composée de plusieurs composantes, devant être instanciées et configurées
// Tout cela est fait grâce à une classe de base
require_once ROOT . "/Src/BaseApp.php";
$app = new Src\BaseApp();

// TODO Réception des erreurs
$app->launchApp(); // Cette méthode regroupe tout ce que fait l'application,
// et donc toutes les erreurs pouvant être renvoyées par celle-ci
