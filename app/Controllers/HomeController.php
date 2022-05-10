<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;

class HomeController extends AbstractController
{
    public function indexGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        return $this->renderPlainText('App setup success');
    }
}
