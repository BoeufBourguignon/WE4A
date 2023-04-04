<?php

namespace Managers;

class PostManager extends Database
{
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

}