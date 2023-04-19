<?php

namespace Model;

/**
 * Classe correspondante à la table Post de la BDD
 */
class Post
{
    private int $idPost;
    private string $title;
    private string $content;
    private string $datePost;
    private int $idUser;
    private int $idCategory;
    private int $nbComment; // Donnée calculée. Nombre de commentaires

    // On offre la possiblité de faire de la navigabilité, en instanciant des objets si nécessaire
    private ?User $user = null;
    private ?Category $category = null;

    /**
     * @return int
     */
    public function getIdPost(): int
    {
        return $this->idPost;
    }

    /**
     * @param int $idPost
     */
    public function setIdPost(int $idPost): void
    {
        $this->idPost = $idPost;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getDatePost(): string
    {
        return $this->datePost;
    }

    /**
     * @param string $datePost
     */
    public function setDatePost(string $datePost): void
    {
        $this->datePost = $datePost;
    }

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdCategory(): int
    {
        return $this->idCategory;
    }

    /**
     * @param int $idCategory
     */
    public function setIdCategory(int $idCategory): void
    {
        $this->idCategory = $idCategory;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return int
     */
    public function getNbComment(): int
    {
        return $this->nbComment;
    }

    /**
     * @param int $nbComment
     */
    public function setNbComment(int $nbComment): void
    {
        $this->nbComment = $nbComment;
    }
}