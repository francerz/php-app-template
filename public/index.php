<?php

use App\Application;
use Dotenv\Dotenv;
use Francerz\Http\Utils\HttpHelper;

(function () {
    $displayErrors = ini_get('display_errors');
    ini_set('display_errors', 'On');

    $autoloadPath = dirname(__FILE__, 2) . '/vendor/autoload.php';
    if (!file_exists($autoloadPath)) {
        trigger_error("Missing 'vendor/autoload.php'. Please execute 'composer install'.", E_USER_ERROR);
    }
    require_once $autoloadPath;

    $envPath = dirname(__FILE__, 2) . '/.env';
    if (!file_exists($envPath)) {
        trigger_error("Missing '.env' file. Please copy '.env.dist' as '.env'.", E_USER_ERROR);
    }
    $dotenv = Dotenv::createImmutable(dirname($envPath), basename($envPath));
    $dotenv->load();

    if (isset($_ENV['DEFAULT_TIMEZONE'])) {
        date_default_timezone_set($_ENV['DEFAULT_TIMEZONE']);
    }
    if (isset($_ENV['SESSION_NAME'])) {
        session_name($_ENV['SESSION_NAME']);
    }

    ini_set('display_errors', $displayErrors);
})();

(function () {
    HttpHelper::redirectToScript();
    $app = new Application();
    $app->run();
})();
