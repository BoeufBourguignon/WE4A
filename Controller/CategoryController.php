<?php

namespace Controller;

use Src\ControllerBase;
use Src\Routing\Route;

class CategoryController extends ControllerBase
{
    #[Route("/category/create", name:"Create a category")]
    public function addCateg()
    {
        echo "salut";
    }
}