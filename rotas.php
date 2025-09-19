<?php

use Code\Framework\Route\Router;

Router::get(
    'buscar',
    '\Code\App\Controller\BuscaController@index',
    [\Code\App\Middleware\TokenAccessMiddleware::class]
);

Router::post('cadastro', '\Code\App\Controller\AuthController@cadastro');
Router::post('login', '\Code\App\Controller\AuthController@login');

Router::post(
    'imoveis-fotos-upload',
    '\Code\App\Controller\ImovelFotosController@upload'
);

Router::api(
    'imoveis',
    '\Code\App\Controller\ImoveisController'
    /*, middlewares: [\Code\App\Middleware\TokenAccessMiddleware::class]*/
);

Router::get('test', fn() => 'Hello World');


Router::get('validar-token', function () {
    $request = \Code\Framework\HTTP\Request::criarRequest();
    $jwt = new \Code\App\Service\JWTService();

    list($bearer, $token) = explode(' ', $request->server('HTTP_AUTHORIZATION'));

    return (string) $jwt->validarToken($token) ? 'Pass' : 'You shaw not pass...';
});
