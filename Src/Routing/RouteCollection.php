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

    public function getRoute(string $route): Route|false
    {
        return array_key_exists($route, $this->routes) ? $this->routes[$route] : false;
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

        $files = array_diff(scandir(self::CONTROLLERS), array('..', '.'));
        foreach($files as $file)
        {
            $class = pathinfo($file, PATHINFO_FILENAME);

            // La on fait la reflection sur la fichier
            $r = new \ReflectionClass("Controller\\" . $class);
            foreach($r->getMethods() as $method)
            {
                foreach($method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF) as $attr)
                {
                    $route = $attr->newInstance();

                    $route->setMethod($method);

                    $this->routes[$route->getPath()] = $route;
                }
            }
        }
    }
}