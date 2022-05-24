<?php

namespace App\Middlewares;

use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Francerz\Console\BackColors;
use Francerz\Console\ForeColors;
use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;
use Psr\Http\Server\RequestHandlerInterface as IRequestHandler;
use Slim\Psr7\Response;

class DebugMiddleware extends AbstractMiddleware
{
    public function process(IServerRequest $request, IRequestHandler $handler): IResponse
    {
        try {
            return $handler->handle($request);
        } catch (Exception $ex) {
            if (php_sapi_name() === 'cli-server') {
                error_log(
                    BackColors::RED . ForeColors::WHITE .
                    'ERROR ' . $ex->getMessage() .
                    BackColors::DEFAULT . ForeColors::RED .
                    PHP_EOL . $ex->getTraceAsString() .
                    ForeColors::DEFAULT
                );
            }
            return new Response(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
