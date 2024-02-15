<?php

namespace Code\Framework\Database;

class Database
{
    protected \PDO $conexao;

    public function __construct(protected string $tabela)
    {
        $this->conexao = Conexao::conectar();
    }

    public function selectTodos(string $colunas = '*'): array
    {
        $sql = 'SELECT ' . $colunas . ' FROM ' . $this->tabela;

        $select = $this->conexao->query($sql);

        return $select->fetchAll(\PDO::FETCH_OBJ);
    }

    public function buscar(int $id, string $colunas = '*'): object|bool
    {
        return $this->select(['id' => $id], $colunas, true);
    }

    public function select(array $clausulas, string $colunas = '*', bool $linha = false): array|object|bool
    {
        $sql = 'SELECT ' . $colunas . ' FROM ' . $this->tabela;

        $whereConditions = '';

        foreach ($clausulas as $key => $clausula) {
            $whereConditions .= $whereConditions
                ? ' AND ' . $key . ' = :' . $key
                : $key . ' = :' . $key;
        }

        $sql .= ' WHERE ' . $whereConditions;

        $select = $this->conexao->prepare($sql);

        foreach ($clausulas as $key => $valor) {
            $select->bindValue(':' . $key, $valor, is_integer($valor)
                ? \PDO::PARAM_INT
                : \PDO::PARAM_STR);
        }

        $select->execute();

        return $linha
            ? $select->fetch(\PDO::FETCH_OBJ)
            : $select->fetchAll(\PDO::FETCH_OBJ);
    }

    public function inserir(array $dados): int
    {
        $keys = array_keys($dados);
        $colunas = implode(', ', $keys);
        $binds   = implode(', :', $keys);

        $sql = 'INSERT INTO ' . $this->tabela . '(' . $colunas . ', criado_em, atualizado_em) VALUES(:' . $binds . ', NOW(), NOW())';

        $inserir = $this->conexao->prepare($sql);

        foreach ($dados as $key => $valor) {
            $inserir->bindValue(':' . $key, $valor, is_integer($valor) ? \PDO::PARAM_INT
                : \PDO::PARAM_STR);
        }

        $inserir->execute();

        return $this->conexao->lastInsertId();
    }

    public function atualizar(int $id, array $dados): bool
    {
        $keys = array_keys($dados);
        $binds   = '';

        foreach ($keys as $key) {
            $binds .= $binds
                ? ', ' . $key . ' = :' . $key
                : $key . ' = :' . $key;
        }

        $sql = 'UPDATE ' . $this->tabela . ' SET ' . $binds
            . ', atualizado_em = NOW() WHERE id = :id';

        $atualizar = $this->conexao->prepare($sql);

        foreach ($dados as $key => $valor) {
            $atualizar->bindValue(':' . $key, $valor, is_integer($valor) ? \PDO::PARAM_INT
                : \PDO::PARAM_STR);
        }

        $atualizar->bindValue(':id', $id, \PDO::PARAM_INT);

        return $atualizar->execute();
    }

    public function deletar(int $id): int|bool
    {
        $sql = 'DELETE FROM ' . $this->tabela . ' WHERE id = :id';

        $remover = $this->conexao->prepare($sql);

        $remover->bindValue(':id', $id, \PDO::PARAM_INT);

        $remover->execute();

        return $remover->rowCount();
    }
}
