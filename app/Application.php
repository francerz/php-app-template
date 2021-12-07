<?php

namespace App;

use App\Controllers\HomeController;
use App\Middlewares\MetricsMiddleware;
use Francerz\Http\HttpFactory;
use Francerz\Http\Utils\UriHelper;
use Slim\Factory\AppFactory;
use Slim\App as SlimApp;

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
