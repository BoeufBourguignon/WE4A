<?php

namespace Controller;

use Managers\CategoryManager;
use Managers\CommentManager;
use Managers\PostManager;
use Managers\UserManager;
use Src\ControllerBase;
use Src\Routing\Route;

class PostController extends ControllerBase
{
    /**
     * Permet la modification d'un post
     *
     * @param PostManager $postManager
     * @param int $idPost
     *
     * @return void
     *
     * @throws \Exception
     */
    #[Route("/post/edit/{idPost}")]
    public function editPost(PostManager $postManager, int $idPost): void
    {
        $post = $postManager->getPostById($idPost);

        if ($this->auth->getUser() == null || $this->auth->getUser()->getIdUser() != $post->getIdUser())
            $this->redirect("/post/" . $idPost);


        $this->render("/Post/editPost.php",
            params: ["post" => $post],
            js: ["edit-post"]
        );
    }

    /**
     * Affiche un post et ses commentaires
     * Quelqu'un qui n'est pas connecté peut voir le post
     * Il faut vérifier que le post existe
     *
     * @param PostManager $postManager
     * @param UserManager $userManager
     * @param CategoryManager $categManager
     * @param CommentManager $commentManager
     * @param int $idPost
     *
     * @return void
     *
     * @throws \Exception
     */
    #[Route("/post/{idPost}")]
    public function showPost(
        PostManager $postManager,
        UserManager $userManager,
        CategoryManager $categManager,
        CommentManager $commentManager,
        int $idPost
    ): void
    {
        $post = $postManager->getPostById($idPost);
        if($post == null)
            $this->redirect("/home");
        $postManager->doNavigability([$post], $userManager, $categManager);

        $comments = $commentManager->getCommentsOfPost($idPost);
        foreach($comments as $comment)
        {
            $comment->setUser($userManager->getUserById($comment->getIdUser()));
        }

        $this->render("Post/showPost.php",
            params: ["post" => $post, "comments" => $comments],
            css:["post", "comment"],
            js:["create-comment"]
        );
    }

    /**
     * Poste un post via AJAX
     * Paramètres POST :
     *  - title
     *  - categoryId
     *  - message
     *
     * @param PostManager $postManager
     * @return void
     */
    #[Route("/ajax/post/post", name: "Post post")]
    public function ajaxCreatePost(PostManager $postManager): void
    {
        $response = array();

        if ($this->auth->getUser() == null)
        {
            $response["response"] = false;
        }
        else
        {
            $data = json_decode(file_get_contents('php://input'));

            $title = htmlspecialchars($data->title);
            $categ = htmlspecialchars($data->categoryId);
            $msg = $data->message;

            // Vérification paramètres
            if (
                $categ == null || $categ == 0 ||
                $title == null || strlen($title) == 0 || strlen($title) > 100 ||
                $msg == null || strlen($msg) < 2 || strlen($msg) > 500
            )
            {
                $response["response"] = false;
                $response["debug"] = $msg;
            }
            else
            {
                $response["response"] = $postManager->postPost($this->auth->getUser()->getIdUser(), $categ, $title, $msg);
            }
        }

        $this->renderJSON($response);
    }

    /**
     * Modifie un post via AJAX
     * Paramètres POST :
     *  - title
     *  - msg
     *  - idPost
     *
     * @param PostManager $postManager
     * @return void
     */
    #[Route("/ajax/post/edit")]
    public function ajaxEditPost(PostManager $postManager): void
    {
        $response = array();

        $data = json_decode(file_get_contents("php://input"));

        $title = htmlspecialchars($data->title);
        $msg = $data->message;
        $idPost = htmlspecialchars($data->idPost);

        // Un user peut éditer un post s'il est connecté et que le post lui appartient
        if (
            $this->auth->getUser() == null ||
            $this->auth->getUser()->getIdUser() != $postManager->getPostById($idPost)->getIdUser()
        )
        {
            $response["response"] = false;
        }
        else
        {
            if (
                $title == null || strlen($title) == 0 || strlen($title) > 100 ||
                $msg == null || strlen($msg) < 2 || strlen($msg) > 500 ||
                $idPost == null
            )
            {
                $response["response"] = false;
                $response["debug"] = $msg;
            }
            else
            {
                $response["response"] = $postManager->editPost($idPost, $title, $msg);
            }
        }

        $this->renderJSON($response);
    }

    /**
     * Supprime un post via AJAX
     * Paramètres POST :
     *  - idPost
     *
     * @param PostManager $postManager
     * @return void
     */
    #[Route("/ajax/post/delete")]
    public function ajaxDeletePost(PostManager $postManager): void
    {
        $response = array();

        $data = json_decode(file_get_contents("php://input"));

        $idPost = htmlspecialchars($data->idPost);

        if (
            $this->auth->getUser() == null ||
            $this->auth->getUser()->getIdUser() != $postManager->getPostById($idPost)->getIdUser()
        )
        {
            $response["reponse"] = false;
        }
        else
        {
            if ($idPost == null)
            {
                $response["response"] = false;
            }
            else
            {
                $response["response"] = $postManager->deletePost($idPost);
            }
        }

        $this->renderJSON($response);
    }
}