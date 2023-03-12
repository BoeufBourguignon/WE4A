<?php

namespace Src;

use Src\Routing\RouteCollection;

abstract class ControllerBase
{
    private RouteCollection $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    protected function render(string $vue, array $params = []): void
    {
        if(!file_exists(VUES."/".$vue.".php"))
            throw new \Exception("La vue ".$vue." n'existe pas");

        extract($params);
        include VUES."/base.php";
    }

    protected function redirect(string $route): void
    {
        if($this->routes->getRoute(ltrim($route, "/")) === false)
            throw new \Exception("La route ".$route." n'existe pas dans l'app");

        header("Location: ".$route);
    }
}