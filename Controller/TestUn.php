<?php

namespace Controller;

use Src\ControllerBase;
use Src\Routing\Route;

class TestUn extends ControllerBase
{
    #[Route("/test/salut", name: "route test 2")]
    public function methTestUnDeux(): void
    {
        echo "test 1.2 oui";
    }

    #[Route("/test/{allo}/test", name: "route test 3")]
    public function methTest(): void
    {
        echo "test 1.2 oui";
    }

    #[Route("/test/{allo}/{param}", name: "route test 4")]
    public function methTestDeFou(string $allo, string $param): void
    {
        echo "
        <p>test 1.2 oui</p>
        <p>$allo</p>
        <p>$param</p>
        ";
    }
}
