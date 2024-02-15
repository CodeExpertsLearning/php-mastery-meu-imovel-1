<?php

namespace Code\App\Controller;

use Code\Framework\Database\Database;

class HomeController
{
    public function index()
    {
        //Testar Inserir
        $inserir = new Database('imoveis');
        var_dump($inserir->buscar(2, 'titulo'));
    }
}
