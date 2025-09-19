<?php

namespace Code\Framework\Route;

class Router
{
    private static array $routeCollection = [];

    public static function get(string $uri, string|callable $callback, array $middlewares = []): void
    {
        self::addRoute($uri, $callback, 'GET', $middlewares);
    }

    public static function post(string $uri, string|callable $callback, array $middlewares = []): void
    {
        self::addRoute($uri, $callback, 'POST', $middlewares);
    }

    public static function put(string $uri, string|callable $callback, array $middlewares = []): void
    {
        self::addRoute($uri, $callback, 'PUT', $middlewares);
    }

    public static function delete(string $uri, string|callable $callback, array $middlewares = []): void
    {
        self::addRoute($uri, $callback, 'DELETE', $middlewares);
    }

    public static function api(string $uri, string $controller, array $metodosCustom = [], array $middlewares = [])
    {
        $metodos = [
            'get' => 'index',
            'post' => 'criar',
            'put' => 'atualizar',
            'delete' => 'deletar'
        ];

        /** Add */
        $httpVerbos = array_keys($metodos);

        $metodos = array_merge($metodos, $metodosCustom);
        /** Add */

        foreach ($metodos as $httpVerbo => $metodo) {
            /** Add */
            if (!in_array($httpVerbo, $httpVerbos)) throw new \Exception("Método {$httpVerbo} (use: get, post, put, delete) Inválido no Router");
            /** Add */

            self::{$httpVerbo}($uri, "$controller@$metodo", $middlewares);
        }
    }

    public static function addRoute(string $uri, string|callable $callback, string $method = 'GET', array $middlewares = []): void
    {
        self::$routeCollection[] = [
            'route' => $uri,
            'callback' => $callback,
            'method'   => $method,
            'middlewares' => $middlewares
        ];

        return;
    }

    public static function getRouteCollection(): array
    {
        return self::$routeCollection;
    }
}
