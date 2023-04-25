<?php

namespace Model;

/**
 * Classe correspondante à la table User de la BDD
 */
class User
{
    private int $idUser;
    private string $username;
    private string $passwd;
    private int $idRole;

    /**
     * Crée une nouvelle instance d'User à partir des paramètres
     *
     * @param int $idUser
     * @param string $username
     * @param string $passwd
     * @param int $idRole
     * @return User
     */
    public static function newUser(int $idUser, string $username, string $passwd, int $idRole): User
    {
        $user = new User();
        $user->idUser = $idUser;
        $user->username = $username;
        $user->passwd = $passwd;
        $user->idRole = $idRole;
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
        return file_exists(PFP."/".$this->idUser.".png")
            ? "/photo_de_profil/".$this->idUser.".png"
            : "/PublicAssets/Images/basic-pfp.png";
    }
}