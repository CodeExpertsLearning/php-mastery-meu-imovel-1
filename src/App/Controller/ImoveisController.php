<?php

namespace Code\App\Controller;

use Code\App\Model\Imovel;
use Code\Framework\HTTP\JsonResponse;

class ImoveisController
{
    public function __construct(private Imovel $imovel)
    {
    }

    public function index(int $imovelId = null)
    {
        if ($imovelId) {

            $imovel = $this->imovel->buscar($imovelId);

            if (!$imovel) return new JsonResponse(['data' => ['message' => 'Imóvel não existe!']], 404);

            return new JsonResponse($imovel);
        }

        $imoveis = $this->imovel->selectTodos();

        return new JsonResponse($imoveis);
    }

    public function criar()
    {
        if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
            $post = json_decode(file_get_contents('php://input'));
        } else {
            $post = (object) $_POST;
        }

        $imovel = $this->imovel;
        $imovel->usuario_id = 1;
        $imovel->cidade_id = $post->cidade_id;
        $imovel->estado_id = $post->estado_id;
        $imovel->titulo = $post->titulo;
        $imovel->descricao = $post->descricao;
        $imovel->conteudo = $post->conteudo;
        $imovel->slug = $post->slug;
        $imovel->price = $post->price;
        $imovel->imovel_area = $post->imovel_area;
        $imovel->total_imovel_area = $post->total_imovel_area;
        $imovel->banheiros = $post->banheiros;
        $imovel->quartos = $post->quartos;

        $imovel->salvar();

        return new JsonResponse($imovel);
    }

    public function atualizar(int $imovelId = null)
    {
        if (!$imovelId) {
            return new JsonResponse([
                'dados' => [
                    'mensagem' => 'Imóvel Inválido!'
                ]
            ], 404);
        }

        if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
            $put = json_decode(file_get_contents('php://input'));
        }

        $imovel = $this->imovel->buscar($imovelId);

        if (!$imovel) return new JsonResponse(['data' => ['message' => 'Imóvel não existe!']], 404);

        $imovel->titulo = $put->titulo;
        $imovel->descricao = $put->descricao;

        $imovel->salvar();

        return new JsonResponse([
            'dados' => [
                'mensagem' => 'Imóvel atualizado!',
                'imovel' => $imovel
            ]
        ]);
    }

    public function deletar(int $imovelId = null)
    {
        if (!$imovelId) {

            return new JsonResponse([
                'dados' => [
                    'mensagem' => 'Imóvel Inválido!'
                ]
            ], 404);
        }

        if (!$this->imovel->deletar($imovelId)) {

            return new JsonResponse([
                'dados' => [
                    'mensagem' => 'Nenhum Imóvel a Ser Removido!'
                ]
            ], 404);
        }


        return new JsonResponse([
            'dados' => [
                'mensagem' => 'Imóvel removido com sucesso!'
            ]
        ]);
    }
}
