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

    #[Route("/ajax/create/category", name: "Create a category")]
    public function createCateg(CategoryManager $categoryManager)
    {
        $categ_name = filter_input(INPUT_POST, "categ");

        $response = array("response" => false);
        if($categ_name !== null && $categoryManager->getCategoryByName($categ_name) === false)
        {
            $response["response"] = $categoryManager->addCategory($categ_name);
            $response["categId"] = $categoryManager->getConnection()->lastInsertId();
        }

        $this->renderJSON($response);
    }
}