<?php

use Code\Framework\Route\Router;

require __DIR__ . '/../bootstrap.php';


$url = $_SERVER['REQUEST_URI'];
$url = array_values(array_filter(explode('/', $url))); // /ok -> ['ok'] | /login/login -> ['login', 'login']

Router::get('imoveis', '\Code\App\Controller\ImoveisController@index');
Router::post('imoveis', '\Code\App\Controller\ImoveisController@criar');
Router::put('imoveis', '\Code\App\Controller\ImoveisController@atualizar');
Router::delete('imoveis', '\Code\App\Controller\ImoveisController@deletar');

Router::get('test', fn () => 'Hello World');

var_dump(Router::getRouteCollection());
die;






// if (!class_exists($controller)) return http_response_code(404);

// $action = strtolower($_SERVER['REQUEST_METHOD']) . 'Recurso';

// if (!method_exists($controller, $action)) return http_response_code(404);

// $param = $url[1] ??= null;

// $controller = (new \Code\Framework\Container\Container())->get($controller);

// $response = call_user_func_array([$controller, $action], [$param]);

// echo $response;
