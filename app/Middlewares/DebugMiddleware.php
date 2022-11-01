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
    private $errorResponse = null;

    public function __construct()
    {
        parent::__construct();
        $this->setErrorHandler();
    }

    private function setErrorHandler()
    {
        $errorResponse = &$this->errorResponse;
        set_error_handler(function ($errno, $error) use (&$errorResponse) {
            if (php_sapi_name() === 'cli-server') {
                error_log(
                    BackColors::RED . ForeColors::WHITE .
                    "ERROR {$errno}: {$error}" .
                    BackColors::DEFAULT . ForeColors::DEFAULT
                );
            }
            $errorResponse = new Response(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        });
    }

    private function throwErrorExceptionIfIsset(IResponse $response)
    {
        if (isset($this->errorResponse)) {
            return $this->errorResponse;
        }
        return $response;
    }

    public function process(IServerRequest $request, IRequestHandler $handler): IResponse
    {
        try {
            $response = $handler->handle($request);
            return $this->throwErrorExceptionIfIsset($response);
        } catch (Exception $ex) {
            if (php_sapi_name() === 'cli-server') {
                error_log(
                    BackColors::RED . ForeColors::WHITE .
                    'EXCEPTION ' . get_class($ex) . ": {$ex->getMessage()}" .
                    BackColors::DEFAULT . ForeColors::DEFAULT
                );
            }
            return new Response(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
