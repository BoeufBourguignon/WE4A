<?php

namespace Controller;


use Src\ControllerBase;
use Src\Routing\Route;
use Model\User;

class ProfileController extends ControllerBase
{
    #[Route("/changer_photo_profil")]
    public function changer_photo_profil()
    {
        

if(isset($_FILES['nouvelle_photo_profil'])) {
  $dossier = ROOT."/photo_de_profil/";
  $taille_max = 1000000; // Taille maximale en octets (1 Mo)
  $extensions = array('.jpg', '.jpeg', '.png', '.gif'); // Extensions autorisées
  $extension = strrchr($_FILES['nouvelle_photo_profil']['name'], '.'); // Récupération de l'extension du fichier
  // Vérifications de sécurité
  if(!in_array($extension, $extensions)) {
    $_SESSION["photo_error"]= 'Erreur : le fichier doit être au format JPG, JPEG, PNG ou GIF.';
  }
  elseif(filesize($_FILES['nouvelle_photo_profil']['tmp_name']) > $taille_max) {
    $_SESSION["photo_error"]= 'Erreur : le fichier ne doit pas dépasser 1 Mo.';
  }
  else {
    // Enregistrement du fichier sur le serveur avec le nom d'utilisateur
    $id_utilisateur = $this -> auth -> getUser() -> getIdUser(); // Remplacer par l'ID de l'utilisateur
    $nom_fichier = $id_utilisateur . $extension;
    if(move_uploaded_file($_FILES['nouvelle_photo_profil']['tmp_name'], $dossier . $nom_fichier)) {
        $_SESSION["photo_success"]='La photo de profil a été enregistrée avec succès.';
    }
    else {
        $_SESSION["photo_error"]='Erreur : impossible d\'enregistrer la photo de profil.';
    }
  }
}
$this ->redirect ("/profile");
    }
}