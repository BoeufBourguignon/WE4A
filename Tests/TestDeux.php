<?php

namespace Controller;

use Src\Route\TestAttr;

class TestDeux
{
    #[TestAttr("test21")]
    public function methTestDeuxUn(): void
    {
        echo "test 2.1";
    }

    #[TestAttr("test22")]
    public function methTestDeuxDeux(): void
    {
        echo "test 2.2";
    }

}