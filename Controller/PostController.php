<?php

namespace Controller;

use Managers\PostManager;
use Src\Routing\Route;

class PostController extends \Src\ControllerBase
{
    #[Route("/post/post", name:"Post post")]
    public function post_post(PostManager $postManager)
    {
        $data = json_decode(file_get_contents('php://input'));

        $title = filter_var($data->title);
        $categ = filter_var($data->categoryId);
        $msg = filter_var($data->message);

        $response = array();
        // Vérification paramètres
        if(
            $categ == null || $categ == 0 ||
            $title == null || strlen($title) == 0 || strlen($title) > 100 ||
            $msg == null || strlen($msg) < 2 || strlen($msg) > 500
        ) {
            $response["response"] = false;
        }
        else
        {
            $response["response"] = $postManager->postPost($this->auth->getUser()->getIdUser(), $categ, $title, $msg);
        }

        $this->renderJSON($response);
    }

}