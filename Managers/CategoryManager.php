<?php

namespace Managers;

use Model\Category;

class CategoryManager extends Database
{
    public function searchCategory(string $str): array
    {
        $sql = "
            SELECT nameCategory FROM category
            WHERE nameCategory LIKE :startMatch
                UNION
            SELECT nameCategory FROM category
            WHERE nameCategory LIKE :anyMatch
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindValue("startMatch", $str."%");
        $stmt->bindValue("anyMatch", "%".$str."%");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getCategoryByName(string $categoryName): Category|false
    {
        $sql = "SELECT idCategory, nameCategory FROM category WHERE nameCategory = :name";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("name", $categoryName);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        $stmt->execute();

        return $stmt->fetch();
    }
}