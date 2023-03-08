<?php

namespace Controller;

use Src\Routing\Route;

class TestDeux
{
    #[Route("/test21")]
    public function methTestDeuxUn(): void
    {
        echo "test 2.1";
    }

    #[Route("/test22")]
    public function methTestDeuxDeux(): void
    {
        echo "test 2.2";
    }

}