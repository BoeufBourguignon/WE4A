<?php

namespace Src;

use Src\Routing\Route;
use Src\Routing\RouteCollection;

abstract class ControllerBase
{
    private RouteCollection $routes;
    protected Route $route;
    protected UserAuthentication $auth;


    public function __construct(RouteCollection $routes, Route $route)
    {
        $this->routes = $routes;
        $this->route = $route;
        $this->auth = new UserAuthentication();
    }

    protected function render(string $view, array $params = [], array $css = [], array $js = []): void
    {
        if(!file_exists(VIEWS."/".$view))
            throw new \Exception("La vue ".$view." n'existe pas");

        extract($params);
        include(VIEWS."/base.php");
    }

    protected function redirect(string $route): void
    {
        if($this->routes->getRoute(ltrim($route, "/")) === false)
            throw new \Exception("La route ".$route." n'existe pas dans l'app");

        header("Location: ".$route);
        exit();
    }

    protected function renderJSON(array $array)
    {
        echo json_encode($array);
    }

    protected function includeView(string $view)
    {
        return include ROOT."/Vues/".$view.".php";
    }
}