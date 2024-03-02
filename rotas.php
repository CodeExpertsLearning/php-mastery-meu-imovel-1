<?php

use Code\Framework\Route\Router;

Router::api(
    'imoveis',
    '\Code\App\Controller\ImoveisController'
);
Router::get('test', fn () => 'Hello World');
