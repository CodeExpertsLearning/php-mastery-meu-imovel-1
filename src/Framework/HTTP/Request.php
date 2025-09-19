<?php

namespace Code\Framework\HTTP;

use Exception;

class Request
{
    public function __construct(
        private array $get = [],
        private array $post = [],
        private array $server = []
    ) {
    }

    public static function criarRequest()
    {
        return new static($_GET, $_POST, $_SERVER);
    }

    public function get($key = null, $default = null)
    {
        if (!isset($this->get[$key]))
            return $default;

        return $this->get[$key];
    }

    public function post($key = null)
    {
        if (isset($this->post[$key]))
            return $this->post[$key];

        return $this->post;
    }

    public function json($key = null)
    {
        if ($this->server('CONTENT_TYPE') !== 'application/json') throw new Exception("Content-Type Json Inválido!");

        $post = json_decode(file_get_contents('php://input'), true);

        if (isset($post[$key]))
            return $post[$key];

        return $post;
    }

    public function file($key = null, $default = null)
    {
        $files = $_FILES;

        if (!isset($files[$key]))
            return $default;

        return  $files[$key];
    }


    public function server($key = null, $default = null)
    {
        if (isset($this->server[$key]))
            return $this->server[$key];

        return $default;
    }

    public function query($key = null)
    {
        $query = $this->parsearURL('query');
        parse_str($query, $parametros);

        if (isset($parametros[$key]))
            return $parametros[$key];

        return $parametros;
    }

    public function uri()
    {
        return $this->parsearURL('path');
    }

    private function parsearURL($key = null, string $urlFull = null)
    {
        //Ref.: http://php.net/parse_url
        $urlParseada = parse_url($urlFull ?? $this->server('REQUEST_URI'));

        if (!isset($urlParseada[$key])) return null;

        return $urlParseada[$key];
    }
}
