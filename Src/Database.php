<?php

namespace Src;

use PDO;

/**
 * Classe abstraite servant à l'héirate des managers
 * Contient les infos de connexion à la base de données
 */
abstract class Database
{
    private const HOST = "localhost";
    private const PORT = "3306";
    private const CHARSET = "utf8mb4";
    private const LOGIN = "ProjetWE4A";
    private const PASS = "1P1rSOm2V&&w";
    private const DBNAME = "projet_we4a";

    // Objet statique donc partagé entre toutes les classes
    protected static ?PDO $cnx = null;

    /**
     * A chaque instanciation, instancie un nouvel objet PDO si néecessaire (càd si pas instancié ou si erreur)
     */
    public function __construct()
    {
        if(self::$cnx == null || self::$cnx->errorCode() != null)
        {
            $dsn = "mysql:host=".self::HOST.";port=".self::PORT.";dbname=".self::DBNAME.";charset=".self::CHARSET;
            self::$cnx = new PDO($dsn, self::LOGIN, self::PASS);
        }
    }

    public function getConnection(): PDO
    {
        return self::$cnx;
    }
}
