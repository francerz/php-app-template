<?php

use Dotenv\Dotenv;
use Francerz\Http\Utils\HttpHelper;
use Vendor\App\Application;

(function () {
    $displayErrors = ini_get('display_errors');
    ini_set('display_errors', 'On');

    $autoloadPath = dirname(__FILE__, 2) . '/vendor/autoload.php';
    if (!file_exists($autoloadPath)) {
        trigger_error("Missing file 'vendor/autoload.php'. Please execute 'composer install'.", E_USER_ERROR);
    }
    require_once $autoloadPath;

    $envPath = dirname(__FILE__, 2) . '/.env';
    if (!file_exists($envPath)) {
        trigger_error("Missing file '.env'. Please copy '.env.dist' as '.env'.", E_USER_ERROR);
    }
    $dotenv = Dotenv::createImmutable(dirname($envPath), basename($envPath));
    $dotenv->load();

    ini_set('display_errors', $displayErrors);
})();

(function () {
    HttpHelper::redirectToScript();
    $app = new Application();
    $app->start();
})();
