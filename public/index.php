<?php
require __DIR__ . '/../bootstrap.php';

$url = $_SERVER['REQUEST_URI'];
$url = array_values(array_filter(explode('/', $url))); // /ok -> ['ok'] | /login/login -> ['login', 'login']

$controller = $url[0] ??= 'home';
$action = $url[1] ??= 'index';


$controller = '\MVC\Controller\\' . ucfirst($controller) . 'Controller';

if (!class_exists($controller)) return http_response_code(404);

if (!method_exists($controller, $action)) return http_response_code(404);

$response = call_user_func_array([new $controller, $action], []);

echo $response;
