<?php

namespace App\Controllers;

use App\Application;
use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;

class CalificacionesController extends AbstractController
{
    public function indexGet(IServerRequest $request, IResponse $response, array $params): IResponse
    {
        return Application::getRenderer()->renderView('calificaciones/indexGet', []);
    }
}
