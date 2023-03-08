<?php

namespace Src;

use Src\Routing\RouteCollection;

class BaseApp
{
    private RouteCollection $routeCollection;

    public function __construct()
    {
        $this->doAutoLoad();

        $this->routeCollection = new RouteCollection();
    }

    private function doAutoLoad(): void
    {
        require_once ROOT . "/Src/AutoLoader.php";
        new AutoLoader();
    }


    public function launchApp(): void
    {
        $route = "/".$_GET["url"];

        if(($route = $this->routeCollection->getRoute($route)) !== false)
        {
            $method = $route->getMethod()->getName();
            (new ($route->getMethod()->class))->$method();
        }
        else
        {
            echo "<span style='color:red'>Erreur</span>";
        }
    }
}