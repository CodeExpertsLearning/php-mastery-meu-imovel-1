<?php

namespace Code\App\Controller;

use Code\App\Repository\ImovelFotoRepository;
use Code\App\Service\UploadService;
use Code\Framework\HTTP\JsonResponse;
use Code\Framework\HTTP\Request;

class ImovelFotosController
{
    public function __construct(private ImovelFotoRepository $repository)
    {
    }

    public function upload()
    {
        $request = Request::criarRequest();

        $fotos = $request->file('fotos');

        if (!$fotos) return new JsonResponse(['mensagem' => 'Fotos Inválidas...'], 404);

        $fotos = (new UploadService)
            ->uploadMultiplosArquivos($fotos, 'imoveis');

        $fotos = $this->repository->salvarFotosModel(
            $fotos,
            $request->post('imovel')
        );

        return new JsonResponse([
            'mensagem' => 'Foto(s) Upada(s) com Sucesso!',
            'data' => $fotos
        ]);
    }
}
