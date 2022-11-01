<?php

namespace App\Controllers;

use App\Application;
use Fig\Http\Message\StatusCodeInterface as IStatusCode;
use Psr\Http\Message\ResponseInterface as IResponse;

abstract class AbstractController
{
    /**
     * Returns a ResponseInterface with given content string and Content-Type.
     *
     * @param string $text
     * @param IResponse|null $response
     * @return IResponse
     */
    protected function render(string $text, string $contentType = 'text/plain', ?IResponse $response = null)
    {
        $renderer = Application::getRenderer();
        return $renderer->render($text, $contentType, $response);
    }

    protected function renderJson($data, IResponse $response = null)
    {
        $renderer = Application::getRenderer();
        return $renderer->renderJson($data, $response);
    }

    protected function renderFile(
        string $filepath,
        ?string $filename,
        bool $attachment = false,
        ?IResponse $response = null
    ) {
        $renderer = Application::getRenderer();
        return $renderer->renderFile($filepath, $filename, $attachment, $response);
    }

    protected function renderView(string $view, array $data = [], ?IResponse $response = null)
    {
        $renderer = Application::getRenderer();
        return $renderer->renderView($view, $data, $response);
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
        $renderer = Application::getRenderer();
        return $renderer->renderRedirect($location, $status, $response);
    }
}
