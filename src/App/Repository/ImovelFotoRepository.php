<?php

namespace Code\App\Repository;

use Code\App\Model\ImovelFoto;
use Code\Framework\Database\Model\Model;
use Code\Framework\Database\Repository\RepositoryInterface;

class ImovelFotoRepository implements RepositoryInterface
{
    public function getModel(): Model
    {
        return new ImovelFoto();
    }

    public function salvarFotosModel(array $fotos, int $imovel)
    {
        $models = [];

        foreach ($fotos as $foto) {
            $fotoModel = $this->getModel();
            $fotoModel->imovel_id = $imovel;
            $fotoModel->foto = $foto;
            $fotoModel->thumb = 0;

            $fotoModel->salvar();

            $models[] = $fotoModel;
        }

        return $models;
    }
}
