<?php

namespace Src;

use Src\Routing\Route;

class AutoWiring
{
    /**
     * @throws \Exception
     */
    public static function doAutoWiring(Route $route): array
    {
        $params = array();
        foreach($route->getMethod()->getParameters() as $param)
        {
            if(!$param->getType()->isBuiltin())
            {
                $r = new \ReflectionClass($param->getType()->getName());
                if($r->isInstantiable() && count($r->getConstructor()->getParameters()) == 0)
                    $params[$param->getName()] = new ($param->getType()->getName());
                else
                    throw new \Exception("Le paramètre ".$param->getName()." ne peut pas être autowiré");
            }
            else
            {
                $routeParams = $route->getAllParams();
                if(count($routeParams))
                {
                    $i=0;
                    while($i < count($routeParams) - 1 && $routeParams[$i]->getName() != $param->getName())
                        $i++;
                    if($routeParams[$i]->getName() == $param->getName())
                        $params[$param->getName()] = $routeParams[$i]->getValue();
                }
            }
        }
        return $params;
    }
}