<?php

namespace Managers;

use PDO;

abstract class Database
{
    private const HOST = "localhost";
    private const PORT = "3306";
    private const CHARSET = "utf8";
    private const LOGIN = "ProjetWE4A";
    private const PASS = "1P1rSOm2V&&w";
    private const DBNAME = "projet_we4a";

    protected ?PDO $cnx = null;

    public function __construct()
    {
        $dsn = "mysql:host=".self::HOST.";port=".self::PORT.";dbname=".self::DBNAME.";charset=".self::CHARSET;
        $this->cnx = new PDO($dsn, self::LOGIN, self::PASS);
    }
}
