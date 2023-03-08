<?php

namespace Controller;

use Src\Routing\Route;
use Src\TestClass;

class TestUn
{
    #[Route("/")]
    public function methTestUnUn(string $test, TestClass $class): void
    {
        echo "test 1.1";
        var_dump($test);
        var_dump($class);
    }

    #[Route("/test12")]
    public function methTestUnDeux(): void
    {
        echo "test 1.2 oui";
    }
}