<?php

namespace Src\Routing;

/**
 * Élément d'une Route
 */
class RouteElement
{
    private string $name;
    private bool $isParam;
    private mixed $value;

    /**
     * Accesseur du nom de l'élément
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Mutateur du nom de l'élément
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Accesseur de si l'élément est un paramètre
     *
     * @return bool
     */
    public function isParam(): bool
    {
        return $this->isParam;
    }

    /**
     * Mutateur de si l'élément est un paramètre
     *
     * @param bool $isParam
     * @return void
     */
    public function setIsParam(bool $isParam): void
    {
        $this->isParam = $isParam;
    }

    /**
     * Accesseur de la valeur du paramètre
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Mutateur de la valeur du paramètre
     *
     * @param mixed $value
     * @return void
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}