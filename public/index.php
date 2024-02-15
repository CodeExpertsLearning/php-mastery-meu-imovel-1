<?php

use Code\Framework\Route\Router;
use Code\Framework\Route\RouteResolver;

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../rotas.php';

$app = new RouteResolver(Router::getRouteCollection());

echo $app->resolve();
