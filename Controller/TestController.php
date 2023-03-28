<?php

namespace Controller;

use Src\Routing\Route;

class TestController extends \Src\ControllerBase
{
    #[Route("/ajax/test")]
    public function testAjax()
    {
        echo json_encode(array(
            "test" => "salut",
            "allo" => array(
                "bonjour" => "bonsoir"
            ),
            "stylé non"
        ));
    }

    #[Route("/ajax/test2")]
    public function testAjax2()
    {
        $this->render("test.php");
    }
}