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
        $route = $_GET["url"];

        $route = $this->routeCollection->getRoute($route);

        var_dump($route);
        var_dump($route->getAllParams());

//        if(($route = $this->routeCollection->getRoute($route)) !== false)
//        {
//            $params = array();
//            foreach($route->getMethod()->getParameters() as $param)
//            {
//                if(!$param->getType()->isBuiltin())
//                    $params[$param->getName()] = new ($param->getType()->getName());
//                else
//                {
//                    switch($param->getType()->getName())
//                    {
//                        case "string": $params[$param->getName()] = "je suis un autre string";
//                    }
//                }
//            }
//
//            call_user_func_array([new ($route->getMethod()->class), $route->getMethod()->getName()], $params);
//        }
//        else
//        {
//            echo "<span style='color:red'>Erreur</span>";
//        }
    }
}