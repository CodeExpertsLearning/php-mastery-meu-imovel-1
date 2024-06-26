<?php

use Code\Framework\Route\Router;

Router::get('buscar', '\Code\App\Controller\BuscaController@index');

Router::post(
    'imoveis-fotos-upload',
    '\Code\App\Controller\ImovelFotosController@upload'
);

Router::api(
    'imoveis',
    '\Code\App\Controller\ImoveisController'
);

Router::get('test', fn () => 'Hello World');
