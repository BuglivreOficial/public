<?php
namespace Core\Router;

class Route
{

    public $path;
    public $method;
    public $callback;

    public $middlewares = [];

    public function __construct($method, $path, $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    public function middleware($names)
    {
        // aceita tanto ->middleware('auth')
        // quanto ->middleware(['auth', 'admin'])
        $this->middlewares = is_array($names) ? $names : [$names];
        return $this;
    }
}