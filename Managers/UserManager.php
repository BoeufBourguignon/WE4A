<?php

namespace Managers;

use Model\User;

class UserManager extends Database
{
    public function getUserById(int $id): ?User
    {
        $sql = "SELECT idUser, username, passwd, idRole, avatar FROM user WHERE idUser = :id";

        $stmt = $this->cnx->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);
        $stmt->execute();

        $ret = $stmt->fetch();
        return $ret === false ? null : $ret;
    }

    public function getUserByUsername(string $username): ?User
    {
        $sql = "SELECT idUser, username, passwd, idRole, avatar FROM user WHERE username = :username";

        $stmt = $this->cnx->prepare($sql);
        $stmt->bindParam("username", $username);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);
        $stmt->execute();

        $ret = $stmt->fetch();
        return $ret === false ? null : $ret;
    }

    public function addUser(string $username, string $password): bool
    {
        $sql = "
            INSERT INTO user (username, passwd)
            VALUE (:username, :passwd)
        ";

        $stmt = $this->cnx->prepare($sql);
        $stmt->bindParam("username", $username);
        $stmt->bindParam("passwd", $password);

        return $stmt->execute();
    }
}