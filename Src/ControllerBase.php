<?php

namespace Src;

use Src\Routing\Route;
use Src\Routing\RouteCollection;

/**
 * Classe abstraite servant à l'héritage des controleurs
 */
abstract class ControllerBase
{
    private RouteCollection $routes;
    protected Route $route;
    protected UserAuthentication $auth;

    /**
     * Crée un controleur
     * La collection des routes est utilisée pour vérifier, lors d'un redirection, que la route ciblée existe
     * La route correspond à la route de la page visitée
     *
     * @param RouteCollection $routes
     * @param Route $route
     */
    public function __construct(RouteCollection $routes, Route $route)
    {
        $this->routes = $routes;
        $this->route = $route;
        $this->auth = new UserAuthentication();
    }

    /**
     * Affiche le contenu du fichier $view (contenu HTML)
     *
     * @param string $view Fichier de la vue
     * @param array $params Paramètres transmis à la vue
     * @param array $css Fichiers CSS à inclure en plus
     * @param array $js Fichiers JS à inclure en plus
     *
     * @return void
     *
     * @throws \Exception Le fichier de la vue n'existe pas
     */
    protected function render(string $view, array $params = [], array $css = [], array $js = []): void
    {
        if(!file_exists(VIEWS."/".$view))
            throw new \Exception("La vue ".$view." n'existe pas");

        extract($params);
        include(VIEWS."/base.php");
    }

    /**
     * Redirige vers l'URL $route
     * L'application est arrêtée après la redirection, pour ne pas exécuter de code après celle-ci
     *
     * @param string $route URL de redirection
     *
     * @return void
     *
     * @throws \Exception L'URL $route ne correspond pas à une route existante
     */
    protected function redirect(string $route): void
    {
        if($this->routes->getRoute(ltrim($route, "/")) === false)
            throw new \Exception("La route ".$route." n'existe pas dans l'app");

        header("Location: ".$route);
        exit();
    }

    /**
     * Affiche le contenu du $array en tant que JSON, pour l'AJAX
     *
     * @param array $array
     *
     * @return void
     */
    protected function renderJSON(array $array): void
    {
        echo json_encode($array);
    }
}