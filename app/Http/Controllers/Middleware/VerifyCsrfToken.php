<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Las URIs que deberían ser excluidas de la verificación de CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*', // Excluye las rutas que comienzan con "api/"
    ];
}
