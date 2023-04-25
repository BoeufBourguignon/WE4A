<?php

namespace Src;

use Src\Routing\Route;

/**
 * Selon les paramètres de la méthode associée à une route, l'auto-wiring crée un tableau associatif contenants les
 * valeurs de ces paramètres (instance d'un objet ou valeur si paramètre dans l'URL)
 */
class AutoWiring
{
    /**
     * Détermine les valeurs de chaque paramètre de l'action associée à la Route
     *
     * @param Route $route
     * @return array Tableau associatif : nom du paramètres => valeur du paramètre
     * @throws \Exception
     */
    public static function doAutoWiring(Route $route): array
    {
        $params = array();
        foreach($route->getMethod()->getParameters() as $param)
        {
            // Si le paramètre est une classe, une interface ou un trait
            if(!$param->getType()->isBuiltin())
            {
                $r = new \ReflectionClass($param->getType()->getName());

                // Si la classe est instanciable et a un constructeur par défaut
                if($r->isInstantiable() && count($r->getConstructor()->getParameters()) == 0)
                    // On instancie le classe et on l'associe au nom du paramètres dans l'action
                    $params[$param->getName()] = new ($param->getType()->getName());
                else
                    // Si un paramètre de l'action ne peut pas être utilisée, une erreur est lancée pour ne pas pouvoir
                    // créer ensuite d'erreur dans le corps de l'action
                    throw new \Exception("Le paramètre ".$param->getName()." ne peut pas être auto-wiré");
            }
            else
            {
                // On récupère le paramètre correspondant dans la route
                // Avec une boucle qui s'arrête dès qu'elle trouve une correspondance
                $routeParams = $route->getAllParams();
                if(count($routeParams))
                {
                    $i=0;
                    while($i < count($routeParams) - 1 && $routeParams[$i]->getName() != $param->getName())
                        $i++;
                    // On vérifie si on n'est pas juste arrivé au bout de la liste
                    if($routeParams[$i]->getName() == $param->getName())
                        // On associe le nom du paramètre avec sa valeur dans l'URL
                        $params[$param->getName()] = $routeParams[$i]->getValue();
                }
            }
        }
        return $params;
    }
}