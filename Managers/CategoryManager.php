<?php

namespace Managers;

use Model\Category;

class CategoryManager extends Database
{
    public function searchCategory(string $str): array
    {
        $sql = "
            SELECT idCategory, nameCategory FROM category
            WHERE nameCategory LIKE :startMatch
                UNION
            SELECT idCategory, nameCategory FROM category
            WHERE nameCategory LIKE :anyMatch
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindValue("startMatch", $str."%");
        $stmt->bindValue("anyMatch", "%".$str."%");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCategoryByName(string $categoryName): Category|false
    {
        $sql = "SELECT idCategory, nameCategory FROM category WHERE LOWER(nameCategory) = :name";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("name", $categoryName);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getCategoryById(int $id): Category|false
    {
        $sql = "SELECT idCategory, nameCategory FROM category WHERE idCategory = :id";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function addCategory(string $categName): bool
    {
        $sql = "
            INSERT INTO category (nameCategory)
            VALUE (LOWER(:categName))
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("categName", $categName);

        return $stmt->execute();
    }
}