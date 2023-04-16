<?php

namespace Managers;

use Model\User;
use Src\Database;

class UserManager extends Database
{
    /**
     * Retourne un utilisateur
     *
     * @param int $id Id de l'utilisateur
     * @return User|null null si l'utilisateur n'existe pas
     */
    public function getUserById(int $id): ?User
    {
        $sql = "SELECT idUser, username, passwd, idRole FROM user WHERE idUser = :id";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);
        $stmt->execute();

        $ret = $stmt->fetch();
        return $ret === false ? null : $ret;
    }

    /**
     * Retourne un utilisateur
     *
     * @param string $username Nom de l'utilisateur
     * @return User|null null si l'utilisateur n'existe pas
     */
    public function getUserByUsername(string $username): ?User
    {
        $sql = "SELECT idUser, username, passwd, idRole FROM user WHERE username = :username";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("username", $username);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);
        $stmt->execute();

        $ret = $stmt->fetch();
        return $ret === false ? null : $ret;
    }

    /**
     * Ajoute un nouvel utilisateur à la base de données
     *
     * @param string $username
     * @param string $password
     *
     * @return bool false si erreur
     */
    public function addUser(string $username, string $password): bool
    {
        $sql = "
            INSERT INTO user (username, passwd)
            VALUE (:username, :passwd)
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("username", $username);
        $stmt->bindParam("passwd", $password);

        return $stmt->execute();
    }
}