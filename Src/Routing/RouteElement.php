<?php

namespace Src\Routing;

class RouteElement
{
    private string $name;
    private bool $isParam;

    public function __construct(string $route)
    {
        $route = explode("/", $route);
    }

}