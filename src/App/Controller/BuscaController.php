<?php

namespace Code\App\Controller;

use Code\App\Repository\ImovelRepository;
use Code\Framework\HTTP\JsonResponse;
use Code\Framework\HTTP\Request;

class BuscaController
{
    public function __construct(private ImovelRepository $repository)
    {
    }

    public function index()
    {
        $request = Request::criarRequest();

        return new JsonResponse([
            'data' => $this->repository->filtrarImoveis(
                filtros: $request->get('filtros'),
                colunas: $request->get('colunas', '*'),
                ordenacao: $request->get('ordenacao')
            )
        ]);
    }
}
