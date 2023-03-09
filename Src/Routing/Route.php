<?php

namespace Src\Routing;

use Attribute;

#[Attribute]
class Route
{
    private string $path;
    private ?string $name;
    private ?\ReflectionMethod $method = null;

    public function __construct(string $path, ?string $name = null)
    {
        $this->path = $path;
        $this->name = $name;
    }

    public function getAllElements(): array
    {
        $route = explode("/", ltrim($this->path, "/"));
        $elements = array();

        foreach($route as $element)
        {
            $e = new RouteElement();
            $e->setName(trim($element, "{}"));
            $e->setIsParam(preg_match("/{.*\}/", $element));

            $elements[] = $e;
        }

        return $elements;
    }

    public function getAllParams(): array
    {
        $params = array();
        foreach($this->getAllElements() as $element)
            if($element->isParam())
                $params[] = $element;
        return $params;
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function setMethod(\ReflectionMethod $method): void
    {
        $this->method = $method;
    }

    public function getMethod(): ?\ReflectionMethod
    {
        return $this->method;
    }

    public function getSize(): int
    {
        return count(explode("/", ltrim($this->path, "/")));
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}