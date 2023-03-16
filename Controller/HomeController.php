<?php

namespace Controller;

use Src\ControllerBase;
use Src\Routing\Route;

class HomeController extends ControllerBase
{
    #[Route("/home", name: "Home")]
    public function home(): void
    {
        $this->render("Home/home.php");
    }

    #[Route("/", name: "Home bis")]
    public function homeBis(): void
    {
        $this->redirect("/home");
    }
}