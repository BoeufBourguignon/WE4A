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
        $stmt->bindValue("passwd", password_hash($password, PASSWORD_BCRYPT));

        return $stmt->execute();
    }

    /**
     * Récupère les utilisateurs dont le nom contient le paramètre
     *
     * @param string $str
     *
     * @return array
     */
    public function searchUser(string $str): array
    {
        $sql = "
            SELECT idUser, username
            FROM user
            WHERE username LIKE :startMatch
                UNION
            SELECT idUser, username
            FROM user
            WHERE username LIKE :anyMatch
            LIMIT 6
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindValue("startMatch", $str."%");
        $stmt->bindValue("anyMatch", "%".$str."%");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Modifie le mot de passe d'un utilisateur
     *
     * @param int $idUser
     * @param string $password
     *
     * @return bool
     */
    public function updatePassword(int $idUser, string $password): bool
    {
        $sql = "
            UPDATE user
            SET passwd = :passwd
            WHERE idUser = :idUser
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindValue("passwd", password_hash($password, PASSWORD_BCRYPT));
        $stmt->bindParam("idUser", $idUser);

        return $stmt->execute();
    }

    /**
     * Retourne TRUE si le nom d'utilisateur est utilisé par un autre utilisateur, sinon FALSE
     *
     * @param string $username
     * @param int $idUser
     *
     * @return bool
     */
    public function isUsernameUsedBySomeoneElse(string $username, int $idUser): bool
    {
        $sql = "
            SELECT COUNT(*)
            FROM user 
            WHERE username = :username 
              AND idUser != :idUser
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("username", $username);
        $stmt->bindParam("idUser", $idUser);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Change le nom d'utilisateur d'un certain utilisateur
     *
     * @return bool
     */
    public function updateUsername(string $username, int $idUser): bool
    {
        $sql = "
            UPDATE user 
            SET username = :username 
            WHERE idUser = :idUser
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("username", $username);
        $stmt->bindParam("idUser", $idUser);

        return $stmt->execute();
    }
}