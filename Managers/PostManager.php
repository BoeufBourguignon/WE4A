<?php

namespace Managers;

use Model\Post;

class PostManager extends Database
{
    public function postPost(int $idUser, int $categId, string $title, string $msg): bool
    {
        $sql = "
            INSERT INTO post(title, content, idUser, idCategory) 
            VALUE (:title, :msg, :idUser, :idCateg)
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("title", $title);
        $stmt->bindParam("msg", $msg);
        $stmt->bindParam("idUser", $idUser);
        $stmt->bindParam("idCateg", $categId);

        return $stmt->execute();
    }

    public function getLastPosts(int $idGreaterThan = 0): array
    {
        $sql = "
            SELECT idPost, title, content, datePost, idUser, idCategory
            FROM post
            WHERE idPost > :id
            ORDER BY datePost DESC
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("id", $idGreaterThan);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
