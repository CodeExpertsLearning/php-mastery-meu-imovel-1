<?php

namespace Code\App\Repository;

use Code\App\Model\Imovel;
use Code\Framework\Database\Model\Model;
use Code\Framework\Database\Repository\RepositoryInterface;

class ImovelRepository implements RepositoryInterface
{
    public function getModel(): Model
    {
        return new Imovel();
    }

    public function filtrarImoveis(?string $filtros = '', ?string $colunas = '*', ?string $ordenacao = 'id,DESC')
    {
        //Organizando filtros
        $filtros = array_filter(explode(';', $filtros));
        $filtros = array_map(fn ($filtro) => explode(':', $filtro), $filtros);

        //Organizando filtros
        $ordenacao = array_filter(explode(';', $ordenacao));
        $ordenacao = array_map(fn ($ordena) => explode(':', $ordena), $ordenacao);

        return $this->getModel()->query()->selectCustom(
            $filtros,
            $colunas,
            $ordenacao
        );
    }
}
