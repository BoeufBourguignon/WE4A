<?php
// Les messages d'erreurs entre formulaires (qui changent de pages) sont passés par la SESSION
// Nous initialisons donc la SESSION pour toutes les pages du site
session_start();

// Met la timzeone par défaut sur l UTC+01 Paris
date_default_timezone_set('Europe/Paris');

// On définie des variables globales constants, pouvant être réutilisées partout dans le code
const ROOT = __DIR__; // Répertoire du fichier index.php
const VIEWS = ROOT."/Vues"; // Répertoire où sont situées les vues
const PFP = ROOT."/photo_de_profil"; // Répertoire des photos de profil
const POSTS_IMGS = ROOT."/PublicAssets/Images/Posts"; // Répertoire des images des posts

const MAX_FILE_SIZE = 52428800; // Taille maximale des fichiers uploadables (50Mo)

// L'application est composée de plusieurs composantes, devant être instanciées et configurées
// Tout cela est fait grâce à une classe de base
require_once ROOT . "/Src/BaseApp.php";
$app = new Src\BaseApp();

try
{
    $app->launchApp(); // Cette méthode regroupe tout ce que fait l'application,
    // et donc toutes les erreurs pouvant être renvoyées par celle-ci
}
catch(Exception $e)
{
    include(VIEWS."/erreur.php");
}
