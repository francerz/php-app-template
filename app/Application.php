<?php

namespace App;

use App\Controllers\HomeController;
use App\Middlewares\DebugMiddleware;
use App\Middlewares\MetricsMiddleware;
use Francerz\Http\HttpFactory;
use Francerz\Http\Utils\UriHelper;
use Francerz\WebappRenderUtils\Renderer;
use Slim\Factory\AppFactory;
use Slim\App as SlimApp;

class Application
{
    /** @var SlimApp */
    private $slimApp;

    public static function getRenderer()
    {
        static $renderer;
        if (!isset($renderer)) {
            $httpFactory = new HttpFactory();
            $renderer = new Renderer($httpFactory, $httpFactory);
            $renderer->setViewsBasePath(dirname(__FILE__, 2) . '/res/views');
        }
        return $renderer;
    }

    public function start()
    {
        $siteUrl = UriHelper::getSiteUrl();
        $httpManager = HttpFactory::getManager();
        $siteUri = $httpManager->getUriFactory()->createUri($siteUrl);
        $sitePath = $siteUri->getPath();

        $this->slimApp = $slimApp = AppFactory::create();
        $slimApp->setBasePath($sitePath);
        $this->route();
        $slimApp->run();
    }

    public function route()
    {
        $route = $this->slimApp;
        $route->addMiddleware(new MetricsMiddleware());
        $route->addMiddleware(new DebugMiddleware());
        $route->get('[/]', [HomeController::class, 'indexGet']);
    }
}
