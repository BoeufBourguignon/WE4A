<?php

namespace Controller;

use Src\Routing\Route;

class TestUn
{
    #[Route("/")]
    public function methTestUnUn(): void
    {
        echo "test 1.1";
    }

    #[Route("/test12")]
    public function methTestUnDeux(): void
    {
        echo "test 1.2";
    }
}