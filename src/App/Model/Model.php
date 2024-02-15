<?php

namespace Code\App\Model;

use Code\Framework\Database\Database;
use JsonSerializable; //php.net/JsonSerializable

class Model implements JsonSerializable
{
    protected $table;

    protected $atributos = [];

    public function __call($method, $params)
    {
        $database = $this->query();

        if (!method_exists($database, $method)) {
            throw new \Exception("Método {$method} não existe...");
        }

        return $database->{$method}(...$params);
    }

    public function __set($atr, $valor)
    {
        $this->atributos[$atr] = $valor;
    }

    public function __get($atr)
    {
        if (!array_key_exists($atr, $this->atributos)) {
            return null;
        }

        return $this->atributos[$atr];
    }

    public function buscar(int $id): ?Model
    {
        $data = $this->query()->buscar($id);

        if (!$data) return null;

        $model = $this;

        foreach ($data as $coluna => $valor) {
            $model->{$coluna} = $valor;
        }

        return $model;
    }

    public function salvar()
    {
        if (array_key_exists('id', $this->atributos)) {
            $id = $this->atributos['id'];
            unset($this->atributos['id']);

            $this->atualizar($id, $this->atributos);
        } else {
            $this->id = $this->inserir($this->atributos);
        }

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return $this->atributos;
    }

    protected function query(): Database
    {
        return new Database($this->table);
    }
}
