<?php

require 'vendor/autoload.php';


class Route
{
    public $path;
    public $action;
    public $middlewares = [];

    public function __construct($path, $action)
    {
        $this->path = $path;
        $this->action = $action;
    }

    // Este método permite o encadeamento opcional
    public function middleware($name)
    {
        $this->middlewares[] = $name;
        return $this;
    }
}

class Router
{
    private static $routes = [];

    public static function get($path, $action)
    {
        $route = new Route($path, $action);
        self::$routes[] = $route;

        // Retornamos a instância da Route, que possui o método ->middleware()
        return $route;
    }

    public static function debug()
    {
        dump(self::$routes);
    }
}

// --- Uso Prático ---

// Funciona com encadeamento
Router::get('/dashboard', 'AdminController@index')->middleware('auth');

// Funciona sem encadeamento (o objeto Route é criado e guardado, mas o retorno é ignorado)
Router::get('/contato', 'SiteController@contato');

Router::debug();