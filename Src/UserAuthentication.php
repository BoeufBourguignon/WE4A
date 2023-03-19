<?php

namespace Src;

use Managers\UserManager;
use Model\User;

class UserAuthentication
{
    private ?User $user = null;
    private UserManager $userManager;

    public function __construct()
    {
        $this->userManager = new UserManager();

        if(isset($_COOKIE["user"]) && is_numeric($_COOKIE["user"]))
        {
            $this->user = $this->userManager->getUserById($_COOKIE["user"]);
        }
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function logUser(User $user): void
    {
        setcookie("user", $user->getIdUser(), time()+24*3600);
    }
}