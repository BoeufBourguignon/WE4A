<?php

namespace Controller;

use Managers\CategoryManager;
use Managers\PostManager;
use Managers\UserManager;
use Src\ControllerBase;
use Src\Routing\Route;

class UserController extends ControllerBase
{
    /**
     * Affiche tous les posts d'un certain utilisateur
     *
     * @param UserManager $userManager
     * @param PostManager $postManager
     * @param CategoryManager $categManager
     * @param string $username
     *
     * @return void
     *
     * @throws \Exception
     */
    #[Route("user/{username}")]
    public function drawUserProfile(
        UserManager $userManager,
        PostManager $postManager,
        CategoryManager $categManager,
        string $username
    ): void
    {
        $user = $userManager->getUserByUsername($username);

        $posts = $postManager->getLastPostsOfUser($username);
        $postManager->doNavigability($posts, $userManager, $categManager);

        $this->render("User/userPage.php",
            params:[
                "user" => $user,
                "username" => $username,
                "posts" => $posts],
            css:["post"]
        );
    }

}