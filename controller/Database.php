<?php


namespace app\controller;
use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;
    private $query;

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }
}