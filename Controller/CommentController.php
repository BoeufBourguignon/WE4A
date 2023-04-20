<?php

namespace Controller;

use Managers\CommentManager;
use Src\Routing\Route;

class CommentController extends \Src\ControllerBase
{
    /**
     * Commenter un post
     * Nécessaire : être connecté
     *
     * @param CommentManager $commentManager
     * @return void
     */
    #[Route("/ajax/commentPost/add")]
    public function ajaxCommentPost(CommentManager $commentManager): void
    {
        $response = array();

        // Vérifions si l'utilisateur est connecté
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

    /**
     * Supprimer un commentaire via AJAX
     *
     * @param CommentManager $commentManager
     * @return void
     */
    #[Route("/ajax/comment/delete")]
    public function ajaxDeleteComment(CommentManager $commentManager): void
    {
        $response = array();

        $data = json_decode(file_get_contents("php://input"));
        if($data == null || !isset($data->idComment) || $this->auth->getUser() == null)
        {
            $response["reponse"] = false;
        }
        else
        {
            $idComment = htmlspecialchars($data->idComment);
            $comment = $commentManager->getCommentById($idComment);

            if (
                $comment == null ||
                $this->auth->getUser()->getIdUser() != $comment->getIdUser()
            )
            {
                $response["reponse"] = false;
            }
            else
            {
                $response["response"] = $commentManager->deleteComment($idComment);
            }
        }

        $this->renderJSON($response);
    }
}