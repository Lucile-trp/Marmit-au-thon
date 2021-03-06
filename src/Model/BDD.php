<?php

namespace src\Model;
use PDO;

class BDD
{
    private static $_instance = null;

    protected function __construct()
    {
    } // Constructeur en privé.

    protected function __clone()
    {
    } // Méthode de clonage en privé aussi et vide pour empêcher le clonage

    public static function initInstance()
    {

        try {
            include($_SERVER["DOCUMENT_ROOT"]."/../src/Model/Credentials.php");
            $hostname = $host;
            $username = $user;
            $password = $pass;
            $dbname = $db;

            SELF::$_instance = new PDO('mysql:host=' . $hostname . ';dbname=' . $dbname . ';', $username, $password);

            SELF::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



        } catch (\Exception $e) {
            SELF::$_instance = 'Erreur : ' . $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (SELF::$_instance == null) {
            SELF::initInstance();
        }
        return SELF::$_instance;
    }

}