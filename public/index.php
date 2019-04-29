<?php
declare(strict_types=1);

use Composer\Autoload\ClassLoader;
use \Router\Router;

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

$container = new DI\Container();


if (! class_exists(Router::class)) {
    throw new RuntimeException(
        "Unable to load Router.\n"
        . "- Type `composer install` if you are developing locally.\n"
        . "- Type `docker-compose exec web composer install` if you are using Docker.\n"
    );
}

Router::setControllerRoot('Router\ExampleControllers');
Router::resource('whatever');
Router::resource('whatever.whenever');

$router = $container->get(Router::class);

$router->invokeControllerMethod();
