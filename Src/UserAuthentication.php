<?php

namespace Src;

use Managers\UserManager;
use Model\User;

class UserAuthentication
{
    private ?User $user = null;
    private UserManager $userManager;

    /**
     * Permet de gérer l'authentification de l'utilisateur à l'application
     */
    public function __construct()
    {
        // Récupère l'utilisateur s'il est connecté dans les cookies
        $this->userManager = new UserManager();

        if(isset($_COOKIE["user"]) && is_numeric($_COOKIE["user"]))
        {
            $this->user = $this->userManager->getUserById($_COOKIE["user"]);
        }
    }

    /**
     * Accesseur de l'objet décrivant l'utilisateur connecté
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Connecte l'utilisateur dans les cookies
     *
     * @param User $user
     * @return void
     */
    public function logUser(User $user): void
    {
        setcookie("user", $user->getIdUser(), time()+24*3600);
    }
}