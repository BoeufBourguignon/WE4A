<?php

namespace Src;

class AutoLoader
{
    private static array $dirs = array(
        "Controller\TestDeux" => ROOT . "/Tests/TestDeux.php",
        "Controller\TestUn" => ROOT . "/Tests/TestUn.php",
        "Src\Route\TestAttr" => ROOT . "/TestAttr.php"
    );

    public static function loadClass(string $class): void
    {
        include self::$dirs[$class];
    }

    public function __construct()
    {
        spl_autoload_register("Src\AutoLoader::loadClass");
    }
}