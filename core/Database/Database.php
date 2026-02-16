<?php
namespace Core\Database;

use PDO;
use PDOException;

class Database
{
    private PDO $instance;

    private function __construct()
    {
        try {
            self::$instance = new PDO();
        } catch (PDOException $e) {
            //throw $th;
        }
    }

    public static function getInstance(): PDO
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}