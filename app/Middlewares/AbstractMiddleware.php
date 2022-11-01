<?php

namespace App\Middlewares;

use Psr\Http\Server\MiddlewareInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    public function __construct()
    {
    }
}
