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
    #[Route("/home", name: "Home")]
    public function home(UserManager $userManager, PostManager $postManager, CategoryManager $categManager)
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
            js:["create-post"]);
    }

    #[Route("/", name: "Home bis")]
    public function homeBis()
    {
        $this->redirect("/home");
    }

    #[Route("/login", name:"Login")]
    public function login()
    {
        $this->render("Auth/login.php", css:["login.css"]);
    }

    #[Route("/register", name:"Register")]
    public function register()
    {
        $this->render("Auth/register.php", css:["login.css"], js:["register.js"]);
    }

    #[Route("/profile", name:"Profile")]
    public function profile()
    {
        $this->render("Home/profile.php");
    }
}