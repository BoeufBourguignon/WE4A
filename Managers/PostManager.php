<?php

namespace Managers;

use Model\Post;
use Src\Database;

class PostManager extends Database
{
    /**
     * Publie un nouveau post dans la base de données
     *
     * @param int $idUser Id de l'utilisateur ayant créé le post
     * @param int $categId Id de la catégorie du post
     * @param string $title Titre du post
     * @param string $msg Contenu du post
     *
     * @return bool false si erreur
     */
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

    /**
     * Récupère les derniers posts
     *
     * @param int $idGreaterThan
     * @return array Liste des posts
     */
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
