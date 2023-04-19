<?php

namespace Managers;

use Model\Comment;
use Src\Database;

class CommentManager extends Database
{
    /**
     * Retourne tous les commentaires directs à un post, par odre chronologique
     *
     * @param int $idPost
     *
     * @return array
     */
    public function getCommentsOfPost(int $idPost): array
    {
        $sql = "
            SELECT c.idComment, idUser, content, dateComment
            FROM comment c 
                JOIN comment_post cp on c.idComment = cp.idComment
            WHERE idPost = :idPost
            ORDER BY dateComment DESC
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("idPost", $idPost);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Comment::class);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Ajoute un commentaire à un post
     *
     * @param int $idUser
     * @param int $idPost
     * @param string $content
     *
     * @return bool
     */
    public function addCommentToPost(int $idUser, int $idPost, string $content): bool
    {
        $sqlComment = "
            INSERT INTO comment (idUser, content)
            VALUE (:idUser, :content)
        ";

        $stmtComment = self::$cnx->prepare($sqlComment);
        $stmtComment->bindParam("idUser", $idUser);
        $stmtComment->bindParam("content", $content);

        $successComment = $stmtComment->execute();

        if($successComment)
        {
            $idComment = self::$cnx->lastInsertId();
            $sqlCommentPost = "
                INSERT INTO comment_post (idComment, idPost) 
                VALUE (:idComment, :idPost)
            ";

            $stmtCommentPost = self::$cnx->prepare($sqlCommentPost);
            $stmtCommentPost->bindParam("idComment", $idComment);
            $stmtCommentPost->bindParam("idPost", $idPost);

            $successComment = $stmtCommentPost->execute();
        }

        return $successComment;
    }
}