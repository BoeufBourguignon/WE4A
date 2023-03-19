<?php

namespace Model;

class User
{
    private int $idUser;
    private string $username;
    private string $passwd;
    private int $idRole;
    private ?string $avatar;

    public static function newUser(int $idUser, string $username, string $passwd, int $idRole, ?string $avatar): User
    {
        $user = new User();
        $user->idUser = $idUser;
        $user->username = $username;
        $user->passwd = $passwd;
        $user->idRole = $idRole;
        $user->avatar = $avatar;
        return $user;
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setLogin(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPasswd(): string
    {
        return $this->passwd;
    }

    /**
     * @param string $passwd
     */
    public function setPasswd(string $passwd): void
    {
        $this->passwd = $passwd;
    }

    /**
     * @return int
     */
    public function getIdRole(): int
    {
        return $this->idRole;
    }

    /**
     * @param int $idRole
     */
    public function setIdRole(int $idRole): void
    {
        $this->idRole = $idRole;
    }

    /**
     * @return ?string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param ?string $avatar
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }
}