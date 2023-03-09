<?php

namespace Src;

use Src\Routing\RouteCollection;

class BaseApp
{
    private RouteCollection $routeCollection;
    private AutoWiring $autoWiring;

    public function __construct()
    {
        $this->doAutoLoad();

        $this->routeCollection = new RouteCollection();
        $this->autoWiring = new AutoWiring();
    }

    private function doAutoLoad(): void
    {
        require_once ROOT . "/Src/AutoLoader.php";
        new AutoLoader();
    }


    /**
     * @throws \Exception
     */
    public function launchApp(): void
    {
        $url = $_GET["url"];

        if(($route = $this->routeCollection->getRoute($url)) !== false)
        {
            $params = $this->autoWiring->doAutoWiring($route);

            call_user_func_array([new ($route->getMethod()->class), $route->getMethod()->getName()], $params);
        }
        else
        {
            echo "<span style='color:red'>Erreur</span>";
        }
    }
}