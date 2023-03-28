<?php

namespace Controller;

use Src\ControllerBase;
use Src\Routing\Route;

class CategoryController extends ControllerBase
{
    #[Route("/add/category", name:"Create a category")]
    public function addCateg()
    {
        $this->render("Category/createCategory.php", params:["navbar" => false]);
    }
}