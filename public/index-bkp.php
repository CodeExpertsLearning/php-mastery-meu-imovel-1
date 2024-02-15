<?php

// use Code\Framework\Container\Container;
// use Code\Framework\Database\Database;

require __DIR__ . '/../bootstrap.php';


$url = $_SERVER['REQUEST_URI'];
$url = array_values(array_filter(explode('/', $url))); // /ok -> ['ok'] | /login/login -> ['login', 'login']



$controller = $url[0] ??= 'home';

$controller = '\Code\App\Controller\\' . ucfirst($controller) . 'Controller';

if (!class_exists($controller)) return http_response_code(404);

$action = strtolower($_SERVER['REQUEST_METHOD']) . 'Recurso';

if (!method_exists($controller, $action)) return http_response_code(404);

$param = $url[1] ??= null;

$controller = (new \Code\Framework\Container\Container())->get($controller);

$response = call_user_func_array([$controller, $action], [$param]);

echo $response;
