<?php

namespace Controller;

use Src\ControllerBase;
use Src\Routing\Route;

class TestUn extends ControllerBase
{
    #[Route("/home", name: "Home")]
    public function home(): void
    {
        $this->render("home");
    }

    #[Route("/", name: "Home bis")]
    public function homeBis(): void
    {
        $this->redirect("/home");
    }

    #[Route("/test", name: "route test 2")]
    public function methTestUnDeux(): void
    {
        echo "test 1.2 oui";
    }

    #[Route("/test/{allo}/test", name: "route test 3")]
    public function methTest(): void
    {
        echo "test 1.2 oui";
    }

    #[Route("/test/{allo}/{salope}", name: "route test 4")]
    public function methTestDeFou(string $allo, string $salope): void
    {
        echo "
        <p>test 1.2 oui</p>
        <p>$allo</p>
        <p>$salope</p>
        ";
    }
}