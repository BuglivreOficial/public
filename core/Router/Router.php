<?php
namespace Core\Router;

use Core\Router\Route;
use Core\Http\Response;

class Router extends Route
{

    private static array $middlewareMap = [
        "apiKey" => \App\Middleware\ApiKey::class
    ];
    private static $routes = [];
    public static function get(string $path, callable |array $callback)
    {
        return self::all('GET', $path, $callback);
    }
    public static function post(string $path, callable |array $callback)
    {
        return self::all('POST', $path, $callback);
    }
    public static function put(string $path, callable |array $callback)
    {
        return self::all('PUT', $path, $callback);
    }
    public static function delete(string $path, callable |array $callback)
    {
        return self::all('DELETE', $path, $callback);
    }

    public static function all(string $method, string $path, callable |array $callback)
    {
        $route = new Route($method, $path, $callback);
        self::$routes[] = $route;

        return $route;
    }

    public static function start(string $uri, string $method)
    {
        foreach (self::$routes as $route) {
            // /manga/{id}        vira    #^/manga/([^/]+)$#
            $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route->path);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                if ($route->method !== $method) {
                    (new Response())->json([
                        'code' => 'METHOD_NOT_ALLOWED',
                        'message' => 'O método de requisição é conhecido pelo servidor, mas não é suportado pelo recurso de destino.',
                        'at_created' => date('d/m/y H:i:s')
                    ])->status(405)->send();
                }

                foreach ($route->middlewares as $middleware) {
                    if (!isset(self::$middlewareMap[$middleware])) {
                        throw new \Exception("Middleware '$middleware' não encontrado.");
                    }
                    $class = self::$middlewareMap[$middleware];
                    (new $class())->handle();
                }

                $callback = $route->callback;

                array_shift($matches);

                preg_match_all('/\{([^}]+)\}/', $route->path, $paramNames);
                $params = !empty($paramNames[1])
                    ? array_combine($paramNames[1], $matches)
                    : [];
                // resultado: ['id' => '42']

                if (is_array($callback)) {
                    // [NomeController::class, 'nomeMetodo']
                    [$class, $action] = $callback;
                    (new $class())->$action($params);
                }
                else {
                    // função anônima
                    $callback($params);
                }
                return;
            }
        }

        (new Response())->json([
            'code' => 'NOT_FOUND',
            'message' => 'O servidor não consegue encontrar o recurso solicitado.',
            'at_created' => date('d/m/y H:i:s')
        ])->status(404)->send();
    }
}