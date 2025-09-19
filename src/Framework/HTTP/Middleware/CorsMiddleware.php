<?php

namespace Code\Framework\HTTP\Middleware;

use Code\Framework\HTTP\Middleware;

class CorsMiddleware implements Middleware
{
    public function handle()
    {

        if (isset($_SERVER['HTTP_ORIGIN'])) {

            header("Access-Control-Allow-Origin: " . HTTP_ORIGIN);
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                $headers = implode(', ', HTTP_HEADERS);
                header("Access-Control-Allow-Methods: {$headers}");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
    }
}
