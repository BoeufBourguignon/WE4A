<?php

namespace Managers;

use Model\Comment;
use Src\Database;

class CommentManager extends Database
{
    /**
     * Retourne le commentaire associé à l'ID, s'il existe
     *
     * @param int $idComment
     *
     * @return Comment|null
     */
    public function getCommentById(int $idComment): ?Comment
    {
        $sql = "
            SELECT idComment, idUser, idPost, content, dateComment, dateModification, isDeleted
            FROM comment
            WHERE idComment = :idComment
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("idComment", $idComment);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Comment::class);
        $stmt->execute();

        $comment = $stmt->fetch();
        return $comment !== false ? $comment : null;
    }

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
            SELECT idComment, idUser, idPost, content, dateComment, dateModification, isDeleted
            FROM comment
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
        $sql = "
            INSERT INTO comment (idUser, content, idPost)
            VALUE (:idUser, :content, :idPost)
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("idUser", $idUser);
        $stmt->bindParam("content", $content);
        $stmt->bindParam("idPost", $idPost);

        return $stmt->execute();
    }

    /**
     * Donne le statut "supprimé" à un commentaire
     *
     * @param int $idComment
     * @return bool
     */
    public function deleteComment(int $idComment): bool
    {
        $sql = "
            UPDATE comment
            SET isDeleted = TRUE, content = ''
            WHERE idComment = :idComment
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("idComment", $idComment);

        return $stmt->execute();
    }

    /**
     * Met à jour un commentaire
     *
     * @param int $idComment
     * @param string $content
     * @return bool
     */
    public function updateComment(int $idComment, string $content): bool
    {
        $sql = "
            UPDATE comment
            SET content = :content, dateModification = NOW()
            WHERE idComment = :idComment
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("content", $content);
        $stmt->bindParam("idComment", $idComment);

        return $stmt->execute();
    }
}