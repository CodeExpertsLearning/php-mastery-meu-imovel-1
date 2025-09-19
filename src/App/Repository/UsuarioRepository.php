<?php

namespace Code\App\Repository;

use Code\App\Model\Usuario;
use Code\App\Model\UsuarioPerfil;
use Code\Framework\Database\Model\Model;
use Code\Framework\Database\Repository\RepositoryInterface;

class UsuarioRepository implements RepositoryInterface
{
    public function getModel(): Model
    {
        return new Usuario();
    }

    public function buscarUsuarioPeloEmail(string $email)
    {
        return $this->getModel()->query()->select(['email' => $email], linha: true);
    }

    public function cadastrarUsuario(array $data, UsuarioPerfil $perfil)
    {
        $usuario = $this->getModel();
        $usuario->nome = $data['nome'];
        $usuario->sobrenome = $data['sobrenome'];
        $usuario->email = $data['email'];
        $usuario->senha = password_hash($data['senha'], PASSWORD_DEFAULT);
        $usuario->salvar();

        $perfil->usuario_id = $usuario->id;
        $perfil->telefone = $data['telefone'];
        $perfil->celular  = $data['celular'];
        $perfil->salvar();

        return $usuario;
    }
}
