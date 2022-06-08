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

    /**
     * Returns a ResponseInterface with given content string and Content-Type.
     *
     * @param string $text
     * @param IResponse|null $response
     * @return IResponse
     */
    protected function render(string $text, string $contentType = 'text/plain', ?IResponse $response = null)
    {
        $response = $response ?? new Response();
        $response = $response->withHeader('Content-Type', $contentType);
        $response->getBody()->write($text);
        return $response;
    }

    protected function renderJson($data)
    {
        return $this->render(json_encode($data), 'application/json');
    }

    protected function renderHTML(string $view, array $data = [])
    {
        return $this->renderer->render($view, $data);
    }

    protected function renderEmail(string $view, array $data = [])
    {
        return $this->renderer->render($view, $data);
    }

    /**
     * Returns a ResponseInterface with redirection headers.
     *
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
