<?php

namespace Code\App\Controller;

use Code\App\Model\UsuarioPerfil;
use Code\App\Repository\UsuarioRepository;
use Code\App\Service\JWTService;
use Code\Framework\HTTP\JsonResponse;
use Code\Framework\HTTP\Request;

class AuthController
{
    public function __construct(
        private UsuarioRepository $repository,
        private JWTService $token
    ) {
    }

    public function login()
    {
        $acesso = (Request::criarRequest())->json();


        if (!$usuario = $this->repository->buscarUsuarioPeloEmail($acesso['email'])) {
            return new JsonResponse(['data' => ['message' => 'Acesso inválido']], 401);
        }

        if (!password_verify($acesso['senha'], $usuario->senha)) {
            return new JsonResponse(['data' => ['message' => 'Acesso inválido']], 401);
        }

        return new JsonResponse([
            'data' =>  [
                'usuario' => $usuario,
                'token'   => $this->token->criarToken(['id' => $usuario->id])
            ]
        ]);
    }

    public function cadastro()
    {
        $dadosCadastro = (Request::criarRequest())->json();

        $usuario = $this->repository->cadastrarUsuario($dadosCadastro, new UsuarioPerfil);

        return new JsonResponse([
            'data' =>  [
                'usuario' => $usuario,
                'token'   => $this->token->criarToken(['id' => $usuario->id])
            ]
        ]);
    }
}
