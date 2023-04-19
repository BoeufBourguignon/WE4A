<?php

namespace Controller;

use Managers\CommentManager;
use Src\Routing\Route;

class CommentController extends \Src\ControllerBase
{
    #[Route("/ajax/commentPost/add")]
    public function ajaxCommentPost(CommentManager $commentManager): void
    {
        $response = array();

        if ($this->auth->getUser() == null)
        {
            $response["response"] = false;
        }
        else
        {
            $data = json_decode(file_get_contents('php://input'));

            $idPost = htmlspecialchars($data->idPost);
            $msg = $data->message;

            // Vérification paramètres
            if (
                $idPost == null || !is_numeric($idPost) ||
                $msg == null || strlen($msg) < 2 || strlen($msg) > 500
            )
            {
                $response["response"] = false;
            }
            else
            {
                $response["response"] =
                    $commentManager->addCommentToPost($this->auth->getUser()->getIdUser(), $idPost, $msg);
            }
        }

        $this->renderJSON($response);
    }

}