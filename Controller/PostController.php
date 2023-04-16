<?php

namespace Controller;

use Managers\PostManager;
use Src\Routing\Route;

class PostController extends \Src\ControllerBase
{
    #[Route("/post/post", name:"Post post")]
    public function post_post(PostManager $postManager)
    {
        $response = array();

        $data = json_decode(file_get_contents('php://input'));

        $title = htmlspecialchars($data->title);
        $categ = htmlspecialchars($data->categoryId);
        $msg = $data->message;

        // Vérification paramètres
        if(
            $categ == null || $categ == 0 ||
            $title == null || strlen($title) == 0 || strlen($title) > 100 ||
            $msg == null || strlen($msg) < 2 || strlen($msg) > 500
        ) {
            $response["response"] = false;
            $response["debug"] = $msg;
        }
        else
        {
            $response["response"] = $postManager->postPost($this->auth->getUser()->getIdUser(), $categ, $title, $msg);
        }

        $this->renderJSON($response);
    }

}