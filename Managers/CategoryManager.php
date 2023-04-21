<?php

namespace Managers;

use Model\Category;
use Src\Database;

class CategoryManager extends Database
{
    /**
     * Retourne une liste de catégories semblables à celle passée en paramètres
     * Méthode utilisée pour faire de l'autocomplétion
     *
     * @param string $str Nom d'une catégorie
     * @return array
     */
    public function searchCategory(string $str): array
    {
        $sql = "
            SELECT idCategory, nameCategory FROM category
            WHERE nameCategory LIKE :startMatch
                UNION
            SELECT idCategory, nameCategory FROM category
            WHERE nameCategory LIKE :anyMatch
            LIMIT 6
        ";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindValue("startMatch", $str."%");
        $stmt->bindValue("anyMatch", "%".$str."%");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Retourne un objet d'une catégorie si elle existe, sinon retourne false
     *
     * @param string $categoryName Nom exact d'une catégorie
     * @return Category|false
     */
    public function getCategoryByName(string $categoryName): Category|false
    {
        $sql = "SELECT idCategory, nameCategory FROM category WHERE LOWER(nameCategory) = :name";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("name", $categoryName);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Retourne un objet d'une catégorie si elle existe, sinon retourne false
     *
     * @param int $id Id de la catégorie
     * @return Category|false
     */
    public function getCategoryById(int $id): Category|false
    {
        $sql = "SELECT idCategory, nameCategory FROM category WHERE idCategory = :id";

        $stmt = self::$cnx->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Ajoute une catégorie à la base de données
     *
     * @param string $categName
     * @return bool false si erreur
     */
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