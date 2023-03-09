<?php

namespace Controller;

use Src\Routing\Route;
use Src\TestClass;

class TestUn
{
    #[Route("/", name: "route test 1")]
    public function methTestUnUn(string $test, TestClass $class): void
    {
        echo "test 1.1";
        var_dump($test);
        var_dump($class);
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