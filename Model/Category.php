<?php

namespace Model;

/**
 * Classe correspondante à la table Category de la BDD
 */
class Category
{
    private int $idCategory;
    private string $nameCategory;

    /**
     * @return int
     */
    public function getIdCategory(): int
    {
        return $this->idCategory;
    }

    /**
     * @param int $idCategory
     */
    public function setIdCategory(int $idCategory): void
    {
        $this->idCategory = $idCategory;
    }

    /**
     * @return string
     */
    public function getNameCategory(): string
    {
        return $this->nameCategory;
    }

    /**
     * @param string $nameCategory
     */
    public function setNameCategory(string $nameCategory): void
    {
        $this->nameCategory = $nameCategory;
    }
}