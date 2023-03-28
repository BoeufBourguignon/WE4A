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

            $class = ($route->getMethod()->class);
            if(!is_subclass_of($class, "Src\\ControllerBase"))
                throw new \Exception("L'action ".$route->getMethod()->getName()." n'est pas dans un controller");

            if($route->isAjax() && (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'))
                throw new \Exception("Pas de l'AJAX");

            $obj = new $class($this->routeCollection, $route);
            call_user_func_array([$obj, $route->getMethod()->getName()], $params);
        }
        else
        {
            echo "<span style='color:red'>Erreur</span>";
        }
    }
}