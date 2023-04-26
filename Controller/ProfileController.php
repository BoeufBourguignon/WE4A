<?php

namespace Controller;


use Src\ControllerBase;
use Src\Routing\Route;
use Managers\UserManager;

class ProfileController extends ControllerBase
{
    /**
     * Permet de modifier la photo de profil liée à un utilisateur
     *
     * @return void
     *
     * @throws \Exception
     */
    #[Route("/changer_photo_profil")]
    public function changer_photo_profil(): void
    {
        if (isset($_FILES['nouvelle_photo_profil']))
        {
            $img = $_FILES['nouvelle_photo_profil'];
            $extension = pathinfo($img["name"], PATHINFO_EXTENSION);

            // Vérifications de sécurité
            if (!in_array($extension, array('jpg', 'jpeg', 'png', 'gif')))
            {
                $_SESSION["photo_error"] = 'Erreur : le fichier doit être au format JPG, JPEG, PNG ou GIF.';
            }
            elseif (filesize($_FILES['nouvelle_photo_profil']['tmp_name']) > MAX_FILE_SIZE)
            {
                $_SESSION["photo_error"] = 'Erreur : le fichier ne doit pas dépasser 1 Mo.';
            }
            else
            {
                // Enregistrement du fichier sur le serveur avec le nom d'utilisateur
                $idUser = $this->auth->getUser()->getIdUser();
                $nom_fichier = $idUser . "." . $extension;
                if (!file_exists(PFP)) {
                    mkdir(PFP, 0777, true);
                }
                // Avant d'ajouter la nouvelle image, on supprime l'ancienne
                $files = glob(PFP . "/".$idUser.".*");
                if($files !== false && count($files) > 0)
                {
                    unlink($files[0]);
                }
                if (move_uploaded_file($_FILES['nouvelle_photo_profil']['tmp_name'], PFP . "/" . $nom_fichier))
                {
                    $_SESSION["photo_success"] = 'La photo de profil a été enregistrée avec succès.';
                }
                else
                {
                    $_SESSION["photo_error"] = 'Erreur : impossible d\'enregistrer la photo de profil.';
                }
            }
        }
        else
        {
            $_SESSION["photo_error"] = 'Erreur : impossible d\'enregistrer la photo de profil.';
        }
        $this->redirect("/profile");
    }


    /**
     * Modifie le mot de passe d'un utilisateur
     *
     * @param UserManager $userManager
     *
     * @return void
     *
     * @throws \Exception
     */
    #[Route("/changer_mot_de_passe")]
    public function changer_mot_de_passe(UserManager $userManager): void
    {
        // Récupération des données du formulaire
        $ancien_mot_de_passe = filter_input(INPUT_POST, "ancien_mot_de_passe");
        $nouveau_mot_de_passe = filter_input(INPUT_POST, "nouveau_mot_de_passe");
        $confirmer_mot_de_passe = filter_input(INPUT_POST, "confirmer_mot_de_passe");

        if(!empty($ancien_mot_de_passe) && !empty($nouveau_mot_de_passe) && !empty($confirmer_mot_de_passe))
        {
            if(strlen($nouveau_mot_de_passe) > 20)
            {
                $_SESSION["mot_de_passe_error"] = "Le mot de passe doit faire moins de 20 caractères";
            }
            else
            {
                if (password_verify($ancien_mot_de_passe, $this->auth->getUser()->getPasswd()))
                {
                    // Si les mots de passe correspondent, on met à jour le mot de passe en base de données
                    if ($nouveau_mot_de_passe == $confirmer_mot_de_passe)
                    {
                        $userManager->updatePassword($this->auth->getUser()->getIdUser(), $nouveau_mot_de_passe);
                        $_SESSION["mot_de_passe_success"] = 'Le mot de passe a été modifié avec succès !';
                    }
                    else
                    {
                        $_SESSION["mot_de_passe_error"] = 'Les nouveaux mots de passe ne correspondent pas.';
                    }
                }
                else
                {
                    $_SESSION["mot_de_passe_error"] = 'L\'ancien mot de passe est incorrect.';
                }
            }
        }
        else
        {
            $_SESSION["mot_de_passe_error"] = 'Veuillez remplir tous les champs.';
        }

        $this->redirect("/profile");
    }

    /**
     * Modifie le nom de l'utilisateur
     *
     * @param UserManager $userManager
     *
     * @return void
     *
     * @throws \Exception
     */
    #[Route("/changer_nom_utilisateur")]
    public function changer_mon_utilisateur(UserManager $userManager): void
    {
        // Récupération des données du formulaire
        $nouveau_nom_utilisateur = filter_input(INPUT_POST, "nouveau_nom_utilisateur");

        if($nouveau_nom_utilisateur != null)
        {
            if(strlen($nouveau_nom_utilisateur) > 20 || strlen($nouveau_nom_utilisateur) < 4)
            {
                $_SESSION["username_error"] = "Le nom d'utilisateur doit faire entre 4 et 20 caractères";
            }
            else
            {
                // Vérification de l'unicité du nouveau nom d'utilisateur
                if (!$userManager->isUsernameUsedBySomeoneElse($nouveau_nom_utilisateur, $this->auth->getUser()->getIdUser()))
                {
                    $userManager->updateUsername($nouveau_nom_utilisateur, $this->auth->getUser()->getIdUser());
                    $_SESSION["username_sucess"] = 'Le nom d\'utilisateur a été mis à jour.';
                }
                else
                {
                    $_SESSION["username_error"] = 'Le nom d\'utilisateur est déjà utilisé par un autre utilisateur.';
                }
            }
        }
        else
        {
            $_SESSION["username_error"] = 'Veuillez remplir tous les champs.';
        }

        $this->redirect("/profile");
    }
}