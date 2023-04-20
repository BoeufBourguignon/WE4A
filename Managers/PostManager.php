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
     * Modifie le titre et le contenu d'un post existant
     *
     * @param int $idPost
     * @param string $title
     * @param string $msg
     *
     * @return bool
     */
    public function editPost(int $idPost, string $title, string $msg): bool
    {
        $sql = "
            UPDATE post
            SET title = :title, content = :msg, dateModification = NOW()
            WHERE idPost = :idPost
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("title", $title);
        $stmt->bindParam("msg", $msg);
        $stmt->bindParam("idPost", $idPost);

        return $stmt->execute();
    }

    /**
     * Supprime un post
     *
     * @param int $idPost
     * @return bool
     */
    public function deletePost(int $idPost): bool
    {
        $sql = "
            DELETE FROM post
            WHERE idPost = :idPost
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("idPost", $idPost);

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
        /** @var Post $post */
        foreach($posts as $post)
        {
            $post->setUser($userManager->getUserById($post->getIdUser()));
            $post->setCategory($categManager->getCategoryById($post->getIdCategory()));
            $post->setNbComment($this->getNbComment($post->getIdPost()));
        }
    }

    /**
     * Récupère le nombre de commentaires directs d'un post
     *
     * @param int $idPost
     *
     * @return int
     */
    public function getNbComment(int $idPost): int
    {
        $sql = "
            SELECT count(*)
            FROM comment c
            WHERE idPost = :idPost
            AND c.isDeleted = FALSE
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("idPost", $idPost);
        $stmt->execute();

        return $stmt->fetchColumn();
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
            SELECT idPost, title, content, datePost, dateModification, idUser, idCategory
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
            SELECT idPost, title, content, datePost, dateModification, idUser, p.idCategory
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
            SELECT idPost, title, content, datePost, dateModification, p.idUser, idCategory
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

    /**
     * @param int $idPost
     *
     * @return Post|null
     */
    public function getPostById(int $idPost): ?Post
    {
        $sql = "
            SELECT idPost, title, content, datePost, dateModification, idUser, idCategory
            FROM post
            WHERE idPost = :idPost
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("idPost", $idPost);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $stmt->execute();

        $post = $stmt->fetch();
        return $post !== false ? $post : null;
    }
}
