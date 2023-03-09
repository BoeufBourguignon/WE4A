<?php

namespace Src\Routing;

use Attribute;

#[Attribute]
class Route
{
    private string $path;
    private ?\ReflectionMethod $method = null;
    private array $routeElements;

    public function __construct(string $path)
    {
        $this->path = $path;

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
}