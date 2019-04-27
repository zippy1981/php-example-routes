<?php

namespace Router;

use \DI\COntainer;

class Router
{
    private $controllerRoot = '\Router\Controllers';
    private $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function getControllerClass(): object
    {
        $uriSegments = explode('/', $this->getUriPath());
        $className = count($uriSegments) >= 4 ? "{$uriSegments[1]}{$uriSegments[3]}" : $uriSegments[1];
        return $this->container->get("{$this->controllerRoot}\\{$className}");
    }

    public function getUriPath(): string
    {
        return $_SERVER['REDIRECT_URL'];
    }

    public function getVerb(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
