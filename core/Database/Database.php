<?php
namespace Core\Database;

use PDO;
use PDOException;

use Core\Http\Response;

class Database
{
  private static ?Database $instance = null; // guarda o Database
  private PDO $connection; // guarda o PDO

  public function __construct() {
    try {
      $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ];

      $this->connection = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'] . '', $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $options);
    } catch (PDOException $e) {
      (new Response())->json([
        'code' => 'INTERNAL_SERVER_ERROR',
        'message' => 'O servidor encontrou uma situação com a qual não sabe lidar.',
        'at_created' => date('d/m/y H:i:s')
      ])->status(500)->send();
    }
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function getConnection(): PDO
  {
    return $this->connection;
  }

  private function __clone() {}
  public function __wakeup() {
    throw new \Exception("Cannot unserialize a singleton.");
  }
}