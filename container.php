<?php
require __DIR__ . '/bootstrap.php';

use Code\Framework\Container\Container;
use Code\Framework\Database\Database;


// Exemplo...

// PSR 11 que trouxe interface Container Interface 
//Com metodos: has e get a serem implementados...

$container = new Container();

$container->set('Code\Framework\Database\Database', function () {
    return new Database('imoveis');
});
$db = $container->get('Code\Framework\Database\Database');
//var_dump($db->buscar(2));


$controller = $container->get('Code\App\Controller\ImoveisController');

var_dump($controller);
