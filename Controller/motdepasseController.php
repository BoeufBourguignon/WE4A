
<?php




use Src\ControllerBase;
use Src\Routing\Route;
use Model\User;

class ProfilController extends ControllerBase
{
    #[Route("/changer_photo_profil")]
    public function changer_photo_profil()
    {
// Récupération des données du formulaire
$ancien_mot_de_passe = $_POST['ancien_mot_de_passe'];
$nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'];
$confirmation_mot_de_passe = $_POST['confirmation_mot_de_passe'];

// Vérification de la correspondance entre l'ancien mot de passe et celui stocké en base de données
$req = $bdd->prepare('SELECT psswd FROM user WHERE idUser = :idUser');
$req->execute(array('idUser' => $_SESSION['idUser']));
$resultat = $req->fetch();

if (password_verify($ancien_mot_de_passe, $resultat['mot_de_passe'])) {
    // Si les mots de passe correspondent, on met à jour le mot de passe en base de données
    if ($nouveau_mot_de_passe == $confirmation_mot_de_passe) {
        $nouveau_mot_de_passe_hash = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT);
        $req = $bdd->prepare('UPDATE user SET psswd = :mot_de_passe WHERE idUser = :idUser');
        $req->execute(array('mot_de_passe' => $nouveau_mot_de_passe_hash, 'idUser' => $_SESSION['idUser']));
        echo 'Le mot de passe a été modifié avec succès !';
    } else {
        echo 'Les nouveaux mots de passe ne correspondent pas.';
    }
} else {
    echo 'L\'ancien mot de passe est incorrect.';
}
$this ->redirect ("/profile");
    }
}
