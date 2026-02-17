<?php

require('vendor/autoload.php');

use Core\Database\Database;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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