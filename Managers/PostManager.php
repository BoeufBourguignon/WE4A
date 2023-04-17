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
     * Instancie les attributs user et category de chaques posts de $posts
     *
     * @param array $posts
     * @param UserManager $userManager
     * @param CategoryManager $categManager
     *
     * @return void
     */
    public function doNavigability(array $posts, UserManager $userManager, CategoryManager $categManager): void
    {
        foreach($posts as $post)
        {
            $post->setUser($userManager->getUserById($post->getIdUser()));
            $post->setCategory($categManager->getCategoryById($post->getIdCategory()));
        }
    }

    /**
     * Récupère les derniers posts
     *
     * @param int $idGreaterThan
     *
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

    /**
     * Récupère les derniers posts d'une certaine catégorie
     *
     * @param string $categName
     * @param int $idGreaterThan
     *
     * @return array
     */
    public function getLastPostsOfCateg(string $categName, int $idGreaterThan = 0): array
    {
        $sql = "
            SELECT idPost, title, content, datePost, idUser, p.idCategory
            FROM post p 
                JOIN category c on p.idCategory = c.idCategory
            WHERE idPost > :id
            AND nameCategory = :categName
            ORDER BY datePost DESC 
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("id", $idGreaterThan);
        $stmt->bindParam("categName", $categName);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Récupère le derniers posts d'un certain utilisateur
     *
     * @param string $username
     * @param int $idGreaterThan
     *
     * @return array
     */
    public function getLastPostsOfUser(string $username, int $idGreaterThan = 0): array
    {
        $sql = "
            SELECT idPost, title, content, datePost, p.idUser, idCategory
            FROM post p 
                JOIN user u on p.idUser = u.idUser
            WHERE idPost > :id
            AND username = :username
            ORDER BY datePost DESC 
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("id", $idGreaterThan);
        $stmt->bindParam("username", $username);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
