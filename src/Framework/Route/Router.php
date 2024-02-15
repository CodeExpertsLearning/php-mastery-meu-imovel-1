<?php

namespace Code\Framework\Route;

class Router
{
    private static array $routeCollection = [];

    public static function get(string $uri, string|callable $callback): void
    {
        self::addRoute($uri, $callback, 'GET');
    }

    public static function post(string $uri, string|callable $callback): void
    {
        self::addRoute($uri, $callback, 'POST');
    }

    public static function put(string $uri, string|callable $callback): void
    {
        self::addRoute($uri, $callback, 'PUT');
    }

    public static function delete(string $uri, string|callable $callback): void
    {
        self::addRoute($uri, $callback, 'DELETE');
    }

    public static function addRoute(string $uri, string|callable $callback, string $method = 'GET'): void
    {
        self::$routeCollection[] = [
            'route' => $uri,
            'callback' => $callback,
            'method'   => $method
        ];

        return;
    }

    public static function getRouteCollection(): array
    {
        return self::$routeCollection;
    }
}
