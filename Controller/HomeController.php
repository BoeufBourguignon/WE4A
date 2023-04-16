<?php

namespace Controller;

use Managers\CategoryManager;
use Managers\PostManager;
use Managers\UserManager;
use Model\Post;
use Src\ControllerBase;
use Src\Routing\Route;

class HomeController extends ControllerBase
{
    /**
     * Page d'accueil : affiche les derniers posts
     *
     * @param UserManager $userManager
     * @param PostManager $postManager
     * @param CategoryManager $categManager
     * @return void
     * @throws \Exception
     */
    #[Route("/home", name: "Home")]
    public function home(UserManager $userManager, PostManager $postManager, CategoryManager $categManager): void
    {
        $posts = $postManager->getLastPosts();
        /** @var Post $post */
        foreach($posts as $post)
        {
            $post->setUser($userManager->getUserById($post->getIdUser()));
            $post->setCategory($categManager->getCategoryById($post->getIdCategory()));
        }

        $this->render("Home/home.php",
            params:["posts" => $posts],
            css:["post"],
            js:["create-post"]);
    }

    /**
     * Redirige vers /home
     *
     * @return void
     * @throws \Exception
     */
    #[Route("/", name: "Home bis")]
    public function homeBis(): void
    {
        $this->redirect("/home");
    }

    /**
     * Affiche la page de connexion
     *
     * @return void
     * @throws \Exception
     */
    #[Route("/login", name:"Login")]
    public function login(): void
    {
        $this->render("Auth/login.php", css:["login.css"]);
    }

    /**
     * Affiche la page d'inscription
     *
     * @return void
     * @throws \Exception
     */
    #[Route("/register", name:"Register")]
    public function register(): void
    {
        $this->render("Auth/register.php", css:["login.css"], js:["register.js"]);
    }

    /**
     * Affiche la page de profil de l'utilisateur
     *
     * @return void
     * @throws \Exception
     */
    #[Route("/profile", name:"Profile")]
    public function profile(): void
    {
        $this->render("Home/profile.php");
    }
}