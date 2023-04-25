<?php

namespace Controller;


use Src\ControllerBase;
use Src\Routing\Route;
use Model\User;
use Managers\UserManager;

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
    $idUser_utilisateur = $this -> auth -> getUser() -> getidUserUser(); // Remplacer par l'idUser de l'utilisateur
    $nom_fichier = $idUser_utilisateur . $extension;
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



    #[Route("/changer_mot_de_passe")]
    public function changer_mot_de_passe()

    {
      $bdd = (new UserManager())->getConnection();
      // Récupération des données du formulaire
$ancien_mot_de_passe = $_POST['ancien_mot_de_passe'];
$nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'];
$confirmer_mot_de_passe = $_POST['confirmer_mot_de_passe'];

// Vérification de la correspondance entre l'ancien mot de passe et celui stocké en base de données
$req = $bdd->prepare('SELECT passwd FROM User WHERE idUser = :idUser');
$req->execute(array('idUser' => $this->auth->getUser()->getIdUser()));
$resultat = $req->fetch();

if (password_verify($ancien_mot_de_passe, $resultat['passwd'])) {
    // Si les mots de passe correspondent, on met à jour le mot de passe en base de données
    if ($nouveau_mot_de_passe == $confirmer_mot_de_passe) {
        $nouveau_mot_de_passe_hash = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT);
        $req = $bdd->prepare('UPDATE user SET passwd = :passwd WHERE idUser = :idUser');
        $req->execute(array('passwd' => $nouveau_mot_de_passe_hash, 'idUser' => $this->auth->getUser()->getIdUser()));
        $_SESSION["mot_de_passe_success"]= 'Le mot de passe a été modifié avec succès !';
    } else {
      $_SESSION["mot_de_passe_error"]='Les nouveaux mots de passe ne correspondent pas.';
    }
} else {
  $_SESSION["mot_de_passe_incorrect"] ='L\'ancien mot de passe est incorrect.';
}
$this ->redirect ("/profile");
    }
    
  


  #[Route("/changer_nom_utilisateur")]
  public function changer_mon_utilisateur()

  {

    $bdd = (new UserManager())->getConnection();

// Récupération des données du formulaire
$nouveau_nom_utilisateur = $_POST['nouveau_nom_utilisateur'];

// Vérification de l'unicité du nouveau nom d'utilisateur
$req = $bdd->prepare('SELECT COUNT(*) AS nb_utilisateurs FROM user WHERE username = :username AND idUser != :idUser');
$req->execute(array('username' => $nouveau_nom_utilisateur, 'idUser' => $this->auth->getUser()->getIdUser()));
$resultat = $req->fetch();

if ($resultat['nb_utilisateurs'] == 0) {
    // Si le nouveau nom d'utilisateur est unique, on met à jour le nom d'utilisateur en base de données
    $req = $bdd->prepare('UPDATE user SET username = :username WHERE idUser = :idUser');
    $req->execute(array('username' => $nouveau_nom_utilisateur, 'idUser' => $this->auth->getUser()->getIdUser()));
    $_SESSION["username_succes"]='Le nom d\'utilisateur a été modifié avec succès !';
} else {
  $_SESSION["username_error"]='Le nom d\'utilisateur est déjà utilisé par un autre utilisateur.';
}
$this ->redirect ("/profile");
  }
}