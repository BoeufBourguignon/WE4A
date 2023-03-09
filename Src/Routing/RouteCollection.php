<?php

namespace Src\Routing;

class RouteCollection
{
    private const CONTROLLERS = ROOT . "/Controller";

    private array $routes = [];

    /**
     * @throws \ReflectionException
     * @throws \Exception Le répertoire de base des controllers n'existe pas
     */
    public function __construct()
    {
        $this->loadRoutes();
    }

    public function getRoute(string $route): false|Route
    {
        $path = explode("/", $route);

        $bestRouteNoParam = null;
        $bestRouteWithParam = null;
        $nbParams = 0;
        /** @var Route $routeObj */
        foreach($this->routes as $routeObj)
        {
            if($routeObj->getSize() != count($path))
                continue;

            $bestRouteNoParam_tmp = true;
            $bestRouteWithParam_tmp = true;

            $nbParams_tmp = 0;

            $bonneRoute = true;
            $i=0;
            $elements = $routeObj->getAllElements();
            while($i < count($elements) && $bonneRoute)
            {
                if($elements[$i]->isParam())    // Si on a au moins un param, la route ne peut pas etre "NoParam"
                {
                    $bestRouteNoParam_tmp = false;
                    ++$nbParams_tmp;
                }
                else
                {
                    if($elements[$i]->getName() != $path[$i])   // Pas un param mais noms différents
                    {
                        $bestRouteNoParam_tmp = false;
                        $bestRouteWithParam_tmp = false;
                        $bonneRoute = false;
                    }
                }

                ++$i;
            }

            if($bestRouteNoParam_tmp) $bestRouteNoParam = $routeObj;
            if($bestRouteWithParam_tmp)
            {
                if($nbParams == 0)
                {
                    $nbParams = $nbParams_tmp;
                    $bestRouteWithParam = $routeObj;
                }
                else if ($nbParams > $nbParams_tmp)
                {
                    $nbParams = $nbParams_tmp;
                    $bestRouteWithParam = $routeObj;
                }
            }
        }

        return $bestRouteNoParam != null
            ? $bestRouteNoParam
            : ($bestRouteWithParam != null
                ? $bestRouteWithParam
                : false);
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception Le répertoire de base des controllers n'existe pas
     */
    private function loadRoutes(): void
    {
        if(!is_dir(self::CONTROLLERS))
        {
            throw new \Exception("Le répertoire de base des controllers n'existe pas");
        }

        $all_paths = array();
        $all_names = array();

        $files = array_diff(scandir(self::CONTROLLERS), array('..', '.'));
        foreach($files as $file)
        {
            $class = pathinfo($file, PATHINFO_FILENAME);

            // La on fait la reflection sur la fichier
            $r = new \ReflectionClass("Controller\\" . $class);
            foreach($r->getMethods() as $method)
            {
                /** @var Route $route */
                $route = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF)[0]->newInstance();

                if(in_array($route->getPath(), $all_paths))
                    throw new \Exception("La route ".$route->getPath()." est en double dans l'application");
                $all_paths[] = $route->getPath();
                if(in_array($route->getName(), $all_names))
                    throw new \Exception("Le nom de route ".$route->getName()." est en double dans l'application");
                if($route->getName() != null)
                    $all_names[] = $route->getName();


                $route->setMethod($method);

                $this->routes[] = $route;
            }
        }
    }
}