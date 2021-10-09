<?php

namespace Vendor\App\Controllers;

use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;

class HomeController extends AbstractController
{
    public function indexGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        $response = $response->withHeader('Content-Type', 'text/plain');
        $response->getBody()->write('App setup success');
        return $response;
    }
}
