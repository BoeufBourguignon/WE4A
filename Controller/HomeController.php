<?php

namespace Controller;

use Src\ControllerBase;
use Src\Routing\Route;
use Src\UserAuthentication;

class HomeController extends ControllerBase
{
    #[Route("/home", name: "Home")]
    public function home(UserAuthentication $auth)
    {
        $this->render("Home/home.php", js:["create-category"]);
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