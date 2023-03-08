<?php

namespace Src;

class AutoLoader
{
    /**
     * @throws \Exception La classe n'est pas dans le même dossier que son namespace
     */
    public static function loadClass(string $class): void
    {
        $file = ROOT."\\".$class.".php";

        if(!file_exists($file))
        {
            throw new \Exception("La classe ".$class." n'est pas dans le même dossier que son namespace");
        }

        require_once $file;
    }

    public function __construct()
    {
        spl_autoload_register("Src\AutoLoader::loadClass");
    }
}