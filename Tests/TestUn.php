<?php

namespace Controller;

use Src\Route\TestAttr;

class TestUn
{
    #[TestAttr("test11")]
    public function methTestUnUn(): void
    {
        echo "test 1.1";
    }

    #[TestAttr("test12")]
    public function methTestUnDeux(): void
    {
        echo "test 1.2";
    }
}