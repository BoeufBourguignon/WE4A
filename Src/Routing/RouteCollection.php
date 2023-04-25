<?php

namespace Src\Routing;

class RouteCollection
{
    private const CONTROLLERS = ROOT . "/Controller";

    private array $routes = [];

    /**
     * Gère toutes les Routes contenus dans des controleurs dans le dossier /Controller
     *
     * @throws \ReflectionException
     * @throws \Exception Le répertoire de base des controllers n'existe pas
     */
    public function __construct()
    {
        // Charge toutes les routes existantes dans les controleurs
        $this->loadRoutes();
    }

    /**
     * Retourne la Route associée à l'URL actuelle
     *
     * @param string $url
     *
     * @return false|Route
     *
     * @throws \Exception
     */
    public function getRoute(string $url): false|Route
    {
        // On transforme l'URL en liste d'éléments
        $path = explode("/", $url);

        // On va chercher la meilleure route, avec param et sans param
        // Si une route sans param existe, on utilisera celle-là en priorité
        // Sinon, et si une route avec param existe, on l'utilise
        // Sinon, false est retourné

        $bestRouteNoParam = null; // Meilleure route sans paramètres
        $bestRouteWithParam = null; // Meilleure route avec paramètres
        $nbParams = 0; // Nombre de paramètres
        /** @var Route $routeObj */
        foreach($this->routes as $routeObj)
        {
            // On vérifie d'abord que la taille de la route courante est égale à la taille de l'URL
            if($routeObj->getSize() != count($path))
                continue;

            // Variables temporaires pour la Route courante
            $bestRouteNoParam_tmp = true;
            $bestRouteWithParam_tmp = true;
            $nbParams_tmp = 0;

            $bonneRoute = true; // Booléen à true tant que la route courante correspond à l'URL
            $i=0;
            $elements = $routeObj->getAllElements();
            // On vérifie chaque éléments de la Route courante et de l'URL tant que nous trouvons des correspondances
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

            // Sans paramètre, une Route et l'URL peuvent correspondre seulement dans un seul cas
            // (Les Routes ne peuvent pas être en doublon)
            // Dans ce cas, on a forcément trouvé la meilleure route sans paramètre
            if($bestRouteNoParam_tmp)
                $bestRouteNoParam = $routeObj;

            // Dans le cas d'une route possible avec paramètres, on vérifie le nombre de paramètres
            // On garde la route avec le moins de paramètres possible
            if($bestRouteWithParam_tmp)
            {
                // La valeur 0 est celle mise à l'initialisation de la variable
                // Une route avec paramètres ne peut pas avoir 0 paramètres, sinon ce serait une route sans paramètre
                // On utilise cette condition pour conserver la première route avec paramètres trouvée
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

        // Valeur retournée par la méthode
        $bestRoute = $bestRouteNoParam != null
            ? $bestRouteNoParam
            : ($bestRouteWithParam != null
                ? $bestRouteWithParam
                : false);

        // Si on a trouvé une Route, on charge ses paramètres
        if($bestRoute instanceof Route)
            $bestRoute->loadParams($path);

        return $bestRoute;
    }

    /**
     * Charge toutes les routes existantes, en leur associant leur action
     *
     * @throws \ReflectionException
     * @throws \Exception Le répertoire de base des controllers n'existe pas
     */
    private function loadRoutes(): void
    {
        // Vérifie que le dossier des controleurs existe
        if(!is_dir(self::CONTROLLERS))
            throw new \Exception("Le répertoire de base des controllers n'existe pas");

        // Variables servant à vérifier qu'une route ou qu'un nom de route ne soit pas présent en double
        $all_paths = array();
        $all_names = array();

        // Récupère tous les fichiers présents dans le dossier /Controller
        $files = array_diff(scandir(self::CONTROLLERS), array('..', '.'));
        foreach($files as $file)
        {
            // Le nom de la classe du controleur correspond au nom du fichier (sans l'extension)
            $class = pathinfo($file, PATHINFO_FILENAME);

            // On recupere les informations du controleur
            $r = new \ReflectionClass("Controller\\" . $class);

            //Chaque méthode du controleur peut éventuellement être une action liée à une route
            foreach($r->getMethods() as $method)
            {
                // Pour chaque méthode du controleur
                // On récupère l'attribut Route. Si l'attribut est en double, il y aura une erreur (l'attribut n'est pas
                // déclaré comme répétable)
                // On obtient forcément un array d'un seul élément, ou un array vide
                $attrs = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);


                if($method->isPublic() && count($attrs))
                {
                    /** @var Route $route */
                    $route = $attrs[0]->newInstance();

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
}