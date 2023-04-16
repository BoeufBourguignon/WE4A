<?php

namespace Controller;

use Managers\UserManager;
use Src\ControllerBase;
use Src\Routing\Route;

class AuthController extends ControllerBase
{
    /**
     * Connecte l'utilisateur s'il existe
     * Paramètres POST :
     *  - username
     *  - password
     *
     * @param UserManager $userManager
     * @return void
     * @throws \Exception
     */
    #[Route("/form_login", name:"Login form")]
    public function login(UserManager $userManager): void
    {
        // Si l'utilisateur est déjà connecté, il n'y a rien à faire
        if($this->auth->getUser() !== null)
            $this->redirect("/profile");

        // Récupère les paramètres POST
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");

        // Vérifie les paramètres et l'existence de l'utilisateur
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
                $_SESSION["last_username"] = $username;
            }
            else
            {
                $this->auth->logUser($user);
                $redirect = "/profile";
            }
        }

        // Si erreur, redirige vers /login, sinon redirige vers /profile
        $this->redirect($redirect);
    }

    /**
     * Crée un nouvel utilisateur
     * Paramètres POST :
     *  - username
     *  - password
     *  - password-verify
     *
     * @param UserManager $userManager
     * @return void
     * @throws \Exception
     */
    #[Route("/form_register", name:"Register form")]
    public function register(UserManager $userManager): void
    {
        // Si l'utilisateur est déjà connecté, il n'y a rien à faire
        if($this->auth->getUser() !== null)
            $this->redirect("/profile");

        // Récupère les paramètres POST
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        $passwordVerify = filter_input(INPUT_POST, "password-verify");

        // Vérifie la validité des paramètres et crée le nouveau compte si tout est bon
        $redirect = "/register";
        if(empty($username) || empty($password) || empty($passwordVerify))
        {
            $_SESSION["register_error"] = "Veuillez remplir tous les champs";
        }
        else
        {
            // Vérifie que le compte n'existe pas
            if($userManager->getUserByUsername($username) != null)
            {
                $_SESSION["register_error"] = "Ce nom d'utilisateur est déjà pris";
            }
            else
            {
                // Vérifie que le mot de passe est au bon format
                if(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password))
                {
                    $_SESSION["register_error"] = "Le mot de passe n'est pas au bon format";
                }
                else
                {
                    if($password != $passwordVerify)
                    {
                        $_SESSION["register_error"] = "Les mots de passe ne correspondent pas";
                    }
                    else
                    {
                        if($userManager->addUser($username, password_hash($password, PASSWORD_BCRYPT)))
                        {
                            $redirect = "/login";
                            $_SESSION["register_success"] = "Le compte a bien été créé";
                        }
                        else
                        {
                            $_SESSION["register_error"] = "Une erreur est survenue";
                        }
                    }
                }
            }
        }

        // Si erreur, redirige vers /register, sinon redirige vers /login
        $this->redirect($redirect);
    }

    /**
     * Déconnecte l'utilisateur (supprime les cookies)
     *
     * @return void
     * @throws \Exception
     */
    #[Route("/logout", name:"Logout")]
    public function logout(): void
    {
        if($this->auth->getUser() != null)
            setcookie("user", null, -1);

        $this->redirect("/home");
    }
}