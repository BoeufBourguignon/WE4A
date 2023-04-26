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
     * Affiche un post et ses commentaires
     * Nécessaire :
     *  - le post existe
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
            js:["post/delete-post", "comment/create-comment", "comment/delete-comment"]
        );
    }

    /**
     * Permet la modification d'un post
     * Nécessaire :
     *  - être connecté
     *  - le post existe
     *  - être l'auteur du post
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

        // Vérifie si l'utilisateur est connecté et s'il est l'auteur du post
        if (    $this->auth->getUser() == null
            || $post == null
            || $this->auth->getUser()->getIdUser() != $post->getIdUser()
        )
            $this->redirect("/post/" . $idPost);


        $this->render("/Post/editPost.php",
            params: ["post" => $post],
            js: ["post/edit-post"]
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
            $title = filter_input(INPUT_POST, "title");
            $categ = filter_input(INPUT_POST, "categoryId");
            $msg = $_POST["message"] ?? null;
            $img = $_FILES["image"] ?? null;

            // Vérification paramètres
            if (
                $categ == null || $categ == 0 ||
                $title == null || strlen($title) == 0 || strlen($title) > 100 ||
                $msg == null || strlen($msg) < 2 || strlen($msg) > 500 ||
                ( $img != null && !in_array($img["type"], ["image/jpeg", "image/png", "image/gif"]) &&
                !file_exists($img["tmp_name"]) && filesize($img["tmp_name"]) > 50000000 )
            )
            {
                $response["response"] = false;
                $response["debug"] = $msg;
            }
            else
            {
                $response["response"] =
                    $postManager->postPost($this->auth->getUser()->getIdUser(), $categ, $title, $msg);

                if($response["response"] && $img != null)
                {
                    $postId = $postManager->getConnection()->lastInsertId();
                    if (!file_exists(POSTS_IMGS)) {
                        mkdir(POSTS_IMGS, 0777, true);
                    }
                    if(!move_uploaded_file($img["tmp_name"],
                            ROOT."/PublicAssets/Images/Posts/".$postId.".".
                            ltrim(strrchr($img["type"], "/"), "/")))
                    {
                        $response["response"] = false;
                        $postManager->deletePost($postId);
                    }
                }
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

        $title = filter_input(INPUT_POST, "title");
        $msg = $_POST["message"] ?? null;
        $idPost = filter_input(INPUT_POST, "idPost");
        $img = $_FILES["image"] ?? null;

        if ($idPost == null ||
            $title == null || strlen($title) == 0 || strlen($title) > 100 ||
            $msg == null || strlen($msg) < 2 || strlen($msg) > 500 ||
            (   $img != null &&
                !in_array(pathinfo($img["name"], PATHINFO_EXTENSION), ["jpeg", "png", "gif", "jpg"]) &&
                !file_exists($img["tmp_name"]) &&
                filesize($img["tmp_name"]) > 50000000 ) ||
            $this->auth->getUser() == null)
        {
            $response["response"] = false;
        }
        else
        {
            // Un user peut éditer un post si le post lui appartient et que le post existe
            $post = $postManager->getPostById($idPost);
            if (
                $post == null ||
                $this->auth->getUser()->getIdUser() != $post->getIdUser()
            )
            {
                $response["response"] = false;
            }
            else
            {
                $response["response"] = $postManager->editPost($idPost, $title, $msg);

                if($response["response"] && $img != null)
                {
                    // Supprime l'ancienne
                    $files = glob(ROOT . "/PublicAssets/Images/Posts/".$idPost.".*");
                    if($files !== false && count($files) > 0)
                    {
                        unlink($files[0]);
                    }

                    // Ajoute la nouvelle
                    $response["response"] = move_uploaded_file($img["tmp_name"],
                        ROOT."/PublicAssets/Images/Posts/".$idPost.".".
                        ltrim(strrchr($img["type"], "/"), "/"));
                }
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

        $post = $postManager->getPostById($idPost);
        if (
            $this->auth->getUser() == null ||
            $post == null ||
            $this->auth->getUser()->getIdUser() != $post->getIdUser()
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
                if($response["response"])
                {
                    $files = glob(ROOT . "/PublicAssets/Images/Posts/".$idPost.".*");
                    if($files !== false && count($files) > 0)
                    {
                        unlink($files[0]);
                    }
                }

            }
        }

        $this->renderJSON($response);
    }
}