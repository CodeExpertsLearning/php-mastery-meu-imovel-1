<?php

namespace Code\Framework\Database;

class Conexao
{
    static private $conexao;

    private function __construct()
    {
    }

    public static function conectar()
    {
        if (!self::$conexao) {
            self::$conexao = new \PDO(
                DB_TIPO . ':dbname=' . DB_NOME . ';host=' . DB_HOST,
                DB_USUARIO,
                DB_SENHA
            );

            self::$conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$conexao->exec('SET NAMES ' . DB_CHARSET . ' COLLATE ' . DB_COLLATE);
        }

        return self::$conexao;
    }
}
