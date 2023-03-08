<?php

namespace Src;

class AutoLoader
{
    private const CONTROLLER = "Controller\\";

    private static array $dirs = array(
        self::CONTROLLER."TestDeux" => ROOT . "/Tests/TestDeux.php",
        self::CONTROLLER."TestUn" => ROOT . "/Tests/TestUn.php",
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