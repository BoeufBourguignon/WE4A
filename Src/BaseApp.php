<?php

namespace Src;

use Src\Routing\RouteCollection;

/**
 *  Cette classe a pour objectif de charger trois composantes de l'application :
 * - L'auto-loader, fait grâce aux namespaces
 * - Les routes, se basants sur l'URL et servant à afficher la bonne page (associée à une fonction d'un controlleur)
 * - L'auto-wiring, permettant de charger facilement des classes dans les controlleurs
 *
 * N.B.: Les routes et l'auto-wiring sont très largement inspirées du framework Symfony 6
 * Les codes ont été faits sans copier pour autant les sources de Symfony, tout a été refait en s'inspirant
 * uniquement de l'utilisation de ces composants, et non de leur implémentation.
 */
class BaseApp
{
    private RouteCollection $routeCollection;

    /**
     * Classe noyau de l'application. Associe la route et son action,
     */
    public function __construct()
    {
        // Permet, lorsqu'une classe est utilisée, d'inclure automatiquement son fichier
        // Le namespace de chaque classe doit correspondre à son répertoire
        // Le nom de la classe doit correspondre au nom de son fichier
        $this->doAutoLoad();

        // Récupère toutes les routes de tous les controlleurs contenus dans le dossier "Controller"
        $this->routeCollection = new RouteCollection();
    }

    /**
     * Met en place l'auto-loading des classes
     *
     * @return void
     */
    private function doAutoLoad(): void
    {
        require_once ROOT . "/Src/AutoLoader.php";
        new AutoLoader();
    }


    /**
     * @throws \Exception Toutes les erreurs générées par l'application
     */
    public function launchApp(): void
    {
        // L'url correspond au paramètre GET "url" et corresond à la Route
        // Grâce au fichier .htaccess, une url du site peut être composée ainsi : www.site.fr/route/voulue,
        // où le paramètre "url" et donc la Route correspondent à "/route/voulue"
        // Le fichier .htaccess permet aussi de supprimer un éventuel "/" final à l'URL, et ne redirige pas les requêtes
        // à destination d'un fichier existant (pour permettre l'intégration du css par exemple)
        // TODO vérifier ce string pour éviter les attaques
        $url = $_GET["url"];

        // On vérifie si la Route existe
        if(($route = $this->routeCollection->getRoute($url)) !== false)
        {
            // On récupère les paramètres via auto-wiring, c'est à dire :
            // On récupère les paramètres de la méthode liée à la Route
            // Si le paramètre de la méthode est un objet instanciable, on l'instancie
            // Si le paramètre de la méthode est un paramètre de la route, on l'associe à la valeur liée dans l'url
            $params = AutoWiring::doAutoWiring($route);

            // On récupère le controlleur contenant l'action de la route voulue
            $controlleur = ($route->getMethod()->class);

            // On vérifie que l'action voulue est dans un Controlleur qui hérite de la classe de base des controlleurs
            if(!is_subclass_of($controlleur, "Src\\ControllerBase"))
                throw new \Exception("L'action ".$route->getMethod()->getName()." n'est pas un controller");

            // Les requêtes AJAX sont envoyées avec un paramètre d'en-tête particulier
            // Lorsque l'on veut accéder à une page AJAX, si la requête n'a pas ce paramètre, il y a une erreur
            if(
                $route->isAjax()
                && (
                    empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                    || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'
                )
            )
                throw new \Exception("Pas de l'AJAX");

            // On instancie le controlleur
            // et on appelle l'action demandée en lui donnant les params trouvés par l'auto-wiring
            $obj = new $controlleur($this->routeCollection, $route);
            call_user_func_array([$obj, $route->getMethod()->getName()], $params);
        }
        else
        {
            throw new \Exception("La route ".$url." n'existe pas");
        }
    }
}