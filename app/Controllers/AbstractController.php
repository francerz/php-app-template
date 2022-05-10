<?php

namespace App\Controllers;

use Fig\Http\Message\StatusCodeInterface as IStatusCode;
use Francerz\Http\HttpFactory;
use Francerz\Render\Renderer;
use Psr\Http\Message\ResponseInterface as IResponse;
use Slim\Psr7\Response;

abstract class AbstractController
{
    private $renderer;

    public function __construct()
    {
        $httpFactory = new HttpFactory();
        $this->renderer = new Renderer($httpFactory, $httpFactory);
        $this->renderer->setViewsPath(dirname(__FILE__, 3) . '/res/views');
    }

    protected function renderHTML(string $view, array $data = [])
    {
        return $this->renderer->render($view, $data);
    }

    protected function renderJson(array $data)
    {
        return $this->renderer->renderJson($data);
    }

    protected function renderEmail(string $view, array $data = [])
    {
        return $this->renderer->render($view, $data);
    }

    protected function renderPlainText(string $text, ?IResponse $response = null)
    {
        $response = $response ?? new Response();
        $response->getBody()->write($text);
        $response->withHeader('Content-Type', 'text/plain');
        return $response;
    }

    /**
     * @param UriInterface|string $location
     * @param int $status
     * @param IResponse|null $response
     * @return IResponse
     */
    protected function redirect($location, $status = IStatusCode::STATUS_FOUND, ?IResponse $response = null)
    {
        $response = $response ?? new Response();
        return $response
            ->withStatus($status)
            ->withHeader('Location', (string)$location);
    }
}
