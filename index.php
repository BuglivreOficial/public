<?php

require('vendor/autoload.php');

use Core\Database\Database;
use Core\Http\Response;

//Vou implementa um sistema de logs
try {
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();
} catch(\Dotenv\Exception\InvalidPathException $e) {
  (new Response())->json([
     'code' => 'INTERNAL_SERVER_ERROR',
        'message' => 'O servidor encontrou uma situação com a qual não sabe lidar.',
        'at_created' => date('d/m/y H:i:s')
  ])->status(500)->send();
}

use Core\Router\Router;

Router::get('/get/{id}', function($id) {
  $db = Database::getInstance()->getConnection();
  dump($db);
})->middleware('apiKey');

Router::post('/post', function($id) {
  dump($id);
  echo 'Rota POST!';
});

Router::put('/put', function () {
  echo 'Rota PUT!';
});

Router::delete('/delete', function() {
  echo 'Rota DELETE!';
});


$url = parse_url($_SERVER['REQUEST_URI'] ?? 'GAME_OVER', PHP_URL_PATH);
$methode = $_SERVER['REQUEST_METHOD'] ?? 'GET';
Router::start($url, $methode);