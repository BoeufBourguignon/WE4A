<?php

namespace Src\Routing;

class RouteElement
{
    private string $name;
    private bool $isParam;
    private mixed $value;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isParam(): bool
    {
        return $this->isParam;
    }

    public function setIsParam(bool $isParam): void
    {
        $this->isParam = $isParam;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}