<?php

namespace Src;

use Src\Routing\RouteCollection;

abstract class ControllerBase
{
    private RouteCollection $routes;

    private Render $render;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    protected function render(string $vue, array $params = []): void
    {
        $this->render = new Render($vue);

        $this->render->render();
    }

    protected function redirect(string $route): void
    {
        if($this->routes->getRoute(ltrim($route, "/")) === false)
            throw new \Exception("La route ".$route." n'existe pas dans l'app");

        header("Location: ".$route);
    }

    protected function includeView(string $view)
    {
        return include ROOT."/Vues/".$view.".php";
    }
}