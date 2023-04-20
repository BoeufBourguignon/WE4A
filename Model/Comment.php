<?php

namespace Model;

class Comment
{
    private int $idComment;
    private int $idUser;
    private string $content;
    private string $dateComment;
    private bool $isDeleted;
    private User $user;

    /**
     * @return int
     */
    public function getIdComment(): int
    {
        return $this->idComment;
    }

    /**
     * @param int $idComment
     */
    public function setIdComment(int $idComment): void
    {
        $this->idComment = $idComment;
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
    public function getDateComment(): string
    {
        return $this->dateComment;
    }

    /**
     * @param string $dateComment
     */
    public function setDateComment(string $dateComment): void
    {
        $this->dateComment = $dateComment;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     */
    public function setIsDeleted(bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}