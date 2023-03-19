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
        $this->render("Home/home.php");
    }

    #[Route("/", name: "Home bis")]
    public function homeBis()
    {
        $this->redirect("/home");
    }

    #[Route("/login", "Login")]
    public function login()
    {
        $this->render("Home/login.php", css:["login.css"]);
    }

    #[Route("/register", name:"Register")]
    public function register()
    {
        $this->render("Home/register.php", css:["login.css"], js:["register.js"]);
    }

    #[Route("/profile", name:"Profile")]
    public function profile()
    {
        $this->render("Home/profile.php");
    }
}