<?php

namespace Code\App\Middleware;

use Code\Framework\HTTP\JsonResponse;
use Code\Framework\HTTP\Middleware;
use Exception;

class TokenAccessMiddleware implements Middleware
{
    public function handle()
    {
        $request = \Code\Framework\HTTP\Request::criarRequest();
        $jwt = new \Code\App\Service\JWTService();

        $authorization =  $request->server('HTTP_AUTHORIZATION');

        if (!$authorization) throw new \Exception('Acesso Inválido!', 401);

        list($bearer, $token) = explode(' ', $authorization);

        if (!$jwt->validarToken($token)) {
            throw new \Exception('Acesso Inválido!', 401);
        }
    }
}
