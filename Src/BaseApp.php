<?php
// Cette classe a pour objectif de charger trois composantes de l'application :
// - L'auto-loader, fait grâce aux namespaces
// - Les routes, se basants sur l'URL et servant à afficher la bonne page (associée à une fonction d'un controlleur)
// - L'auto-wiring, permettant de charger facilement des classes dans les controlleurs

// N.B.: Les routes et l'auto-wiring sont très largement inspirées du framework Symfony 6
// Les codes ont été faits sans copier pour autant les sources de Symfony, tout a été refait en s'inspirant
// uniquement de l'utilisation de ces composants, et non de leur implémentation.

namespace Src;

use Src\Routing\RouteCollection;

/**
 * Classe noyau de l'application
 */
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
        // L'url correspond au paramètre GET "url" et corresond à la Route
        // Grâce au fichier .htaccess, une url du site peut être composée ainsi : www.site.fr/route/voulue,
        // où le paramètre "url" et donc la Route correspondent à "/route/voulue"
        // Le fichier .htaccess permet aussi de supprimer un éventuel "/" final à l'URL, et ne redirige pas les requêtes
        // à destination d'un fichier existant (pour permettre l'intégration du css par exemple)
        // TODO vérifier ce string pour éviter les attaques
        $url = $_GET["url"];

        // On vérifie tout d'abord si la Route spécifiée existe
        if(($route = $this->routeCollection->getRoute($url)) !== false)
        {
            $params = $this->autoWiring->doAutoWiring($route);

            // On récupère le controlleur contenant l'action de la route voulue
            $controlleur = ($route->getMethod()->class);

            // On vérifie que l'action voulue est dans un Controlleur qui hérite de la classe de base des controlleurs
            if(!is_subclass_of($controlleur, "Src\\ControllerBase"))
            {
                throw new \Exception("L'action ".$route->getMethod()->getName()." n'est pas un controller");
            }

            // Les requêtes AJAX sont envoyées avec un paramètre d'en-tête particulier
            // Lorsque l'on cherche à afficher une page AJAX, si la requête n'a pas ce paramètre, il y a une erreur
            if(
                $route->isAjax()
                && (
                    empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                    || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'
                )
            ) {
                throw new \Exception("Pas de l'AJAX");
            }

            // On crée le controlleur et on appelle l'action demandée en y ajoutant les params trouvés par l'auto-wiring
            $obj = new $controlleur($this->routeCollection, $route);
            call_user_func_array([$obj, $route->getMethod()->getName()], $params);
        }
        else
        {
            throw new \Exception("La route ".$url." n'existe pas");
        }
    }
}