<?php

namespace Controller;

use Managers\CategoryManager;
use Src\ControllerBase;
use Src\Routing\Route;

class CategoryController extends ControllerBase
{
    #[Route("/ajax/searchCateg/{nomCateg}", name: "Search a categ", isAjax: true)]
    public function searchCateg(string $nomCateg, CategoryManager $categoryManager)
    {
        $categExists = !($categoryManager->getCategoryByName($nomCateg) === false);

        $categsLike = $categoryManager->searchCategory($nomCateg);

        $this->renderJSON(array("categ_exists" => $categExists, "categs" => $categsLike));
    }

    #[Route("/test/{categ}")]
    public function testCategs(string $categ)
    {
        $this->render("test.php", params:["categ" => $categ]);
    }
}