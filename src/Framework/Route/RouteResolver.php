<?php

namespace Code\Framework\Route;

use Code\Framework\Container\Container;
use Code\Framework\HTTP\Request;
use Exception;

class RouteResolver
{
    private $request;

    public function __construct(private array $routeCollection)
    {
        $this->request = Request::criarRequest();
    }

    public function resolve()
    {
        $uri = trim($this->request->uri(), '/');
        $uri = array_values(array_filter(explode('/', $uri)));

        $method = $this->request->server('REQUEST_METHOD');

        $rota = $this->filtrarRouteCollection($uri[0] ?? '/', $method);

        if (is_string($rota['callback'])) {
            $param = $uri[1] ??= null;
            return $this->resolveController($rota, $param);
        }

        if (is_callable($rota['callback'])) {
            return $rota['callback']();
        }
    }

    private function filtrarRouteCollection($uri, $method)
    {
        $route = array_filter(
            $this->routeCollection,
            function ($rotaConfig) use ($uri, $method) {
                return $rotaConfig['route'] == $uri
                    && $rotaConfig['method'] == $method;
            }
        );

        return current($route);
    }

    public function resolveController(array $rota, ?int $param)
    {
        list($controller, $metodo) = explode('@', $rota['callback']);

        if (!class_exists($controller)) throw new Exception("Controller {$controller} Inválido!");

        $controllerInstancia = (new Container())->get($controller);

        if (!method_exists($controllerInstancia, $metodo)) throw new Exception("Método {$metodo} do controller {$controller} Inválido!");

        return call_user_func_array([$controllerInstancia, $metodo], [$param]);
    }
}
