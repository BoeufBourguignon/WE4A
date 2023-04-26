<?php

namespace Src;

class AutoLoader
{
    /**
     * A chaque fois qu'une nouvelle classe est utilisée, son fichier est automatiquement inclus
     *
     * @throws \Exception La classe n'est pas située au bon endroit/n'a pas un bon namespace
     */
    private static function loadClass(string $class): void
    {
        $file = ROOT."/".str_replace("\\", "/", $class).".php";

        if(!file_exists($file))
        {
            throw new \Exception("La classe ".$class." n'a pas ".$file." comme chemin d'accès");
        }

        require_once $file;
    }

    /**
     * Implémente l'auto-loading des classes
     */
    public function __construct()
    {
        spl_autoload_register("Src\AutoLoader::loadClass");
    }
}