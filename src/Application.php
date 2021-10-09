<?php

namespace Vendor\App;

use Francerz\Http\HttpFactory;
use Francerz\Http\Utils\UriHelper;
use Slim\Factory\AppFactory;
use Slim\App as SlimApp;
use Vendor\App\Controllers\HomeController;
use Vendor\App\Middlewares\MetricsMiddleware;

class Application
{
    /**
     * @var SlimApp
     */
    private $slimApp;

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
        $app = $this->slimApp;
        $app->add(MetricsMiddleware::class);
        $app->get('[/]', [HomeController::class, 'indexGet']);
    }
}
