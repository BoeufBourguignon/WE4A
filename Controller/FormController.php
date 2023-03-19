<?php

namespace Controller;

use Managers\UserManager;
use Src\ControllerBase;
use Src\Routing\Route;

class FormController extends ControllerBase
{
    #[Route("/form_login", name:"Login form")]
    public function login(UserManager $userManager)
    {
        if($this->auth->getUser() !== null)
            $this->redirect("/profile");

        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");

        $redirect = "/login";
        if(empty($username) || empty($password))
        {
            $_SESSION["login_error"] = "Veuillez remplir tous les champs";
        }
        else
        {
            $user = $userManager->getUserByUsername($username);
            if($user == null || !password_verify($password, $user->getPasswd()))
            {
                $_SESSION["login_error"] = "Identifiant ou mot de passe incorrect";
            }
            else
            {
                $this->auth->logUser($user);
                $redirect = "/profile";
            }
        }

        $this->redirect($redirect);
    }

    #[Route("/form_register", name:"Register form")]
    public function register(UserManager $userManager)
    {
        if($this->auth->getUser() !== null)
            $this->redirect("/profile");

        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        $passwordVerify = filter_input(INPUT_POST, "password-verify");

        $redirect = "/register";
        if(empty($username) || empty($password) || empty($passwordVerify))
        {
            $_SESSION["register_error"] = "Veuillez remplir tous les champs";
        }
        else
        {
            if($userManager->getUserByUsername($username) != null)
            {
                $_SESSION["register_error"] = "Ce nom d'utilisateur est déjà pris";
            }
            else
            {
                if($userManager->addUser($username, password_hash($password, PASSWORD_BCRYPT)))
                {
                    $redirect = "/login";
                }
                else
                {
                    $_SESSION["register_error"] = "Une erreur est survenue";
                }
            }
        }

        $this->redirect($redirect);
    }
}