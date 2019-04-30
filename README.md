# PHP Routing Example

## CI/CD

[![CircleCI](https://circleci.com/gh/zippy1981/php-example-routes.svg?style=svg)](https://circleci.com/gh/zippy1981/php-example-routes)
[![codecov](https://codecov.io/gh/zippy1981/php-example-routes/branch/master/graph/badge.svg)](https://codecov.io/gh/zippy1981/php-example-routes)

## Composer stats

[![Latest Stable Version](https://poser.pugx.org/zippy1981/php-routing-example/v/stable)](https://packagist.org/packages/zippy1981/php-routing-example)
[![Total Downloads](https://poser.pugx.org/zippy1981/php-routing-example/downloads)](https://packagist.org/packages/zippy1981/php-routing-example)
[![Latest Unstable Version](https://poser.pugx.org/zippy1981/php-routing-example/v/unstable)](https://packagist.org/packages/zippy1981/php-routing-example)
[![License](https://poser.pugx.org/zippy1981/php-routing-example/license)](https://packagist.org/packages/zippy1981/php-routing-example)

### Download stats

[![Monthly Downloads](https://poser.pugx.org/zippy1981/php-routing-example/d/monthly)](https://packagist.org/packages/zippy1981/php-routing-example)
[![Daily Downloads](https://poser.pugx.org/zippy1981/php-routing-example/d/daily)](https://packagist.org/packages/zippy1981/php-routing-example)

## Using

1. Create a project with `composer init` and follow the prompts.
2. `composer require zippy1981/php-example-routes`.
3. Create a namespace to store your controllers.
4. Add an index.php with the following: 

```php
<?php
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

Router::setControllerRoot('YourControllerNamespace');
Router::resource('whatever');           # parent level controller
Router::resource('whatever.whenever');  # chile level controller

$router = $container->get(Router::class);

$router->invokeControllerMethod();
```