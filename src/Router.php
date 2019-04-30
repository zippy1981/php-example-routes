<?php

namespace Router;

use \DI\Container;

class Router
{
    /**
     * @var string The root of the controller
     */
    private static $controllerRoot = '\Example\Controllers';
    /**
     * @var array registered controllers.
     */
    private static $controllers = [];
    /**
     * @var Container The DI container
     */
    private static $container = null;
    /**
     * @var string The base class name of the controller to invoke.
     */
    private $className;
    private $param1;
    private $param2;
    /**
     * @var string The name of the route;
     */
    private $routeName;
    /**
     * @var bool True if the route is to an index method.
     */
    private $indexRoute;
    /**
     * @var int the level of the route. Either 1 or 2.
     */
    private $routeLevels;
    /**
     * @var int number of segments in the route path.
     */
    private $segmentCount;

    private static function getContainer(): Container
    {
        if (self::$container === null) {
            self::$container = new Container();
        }
        return self::$container;
    }

    public static function resource(string $route)
    {
        $className = self::$controllerRoot . '\\' . str_replace('.', '', $route);
        if (! self::getContainer()->has($className)) {
            throw new ControllerNotFoundException($className);
        }
        $controller = self::getContainer()->get($className);
        if (! $controller instanceof ControllerInterface) {
            throw new InvalidControllerException($className);
        }
        self::$controllers[strtolower($route)] = $controller;
    }

    /**
     * Sets the namespace root of the controller classes.
     * @param string $controllerRoot
     */
    public static function setControllerRoot(string $controllerRoot) :void
    {
        self::$controllerRoot = $controllerRoot;
    }

    public function __construct()
    {
        $uriSegments = explode('/', trim($this->getUriPath(), "/"));
        $this->segmentCount = count($uriSegments);
        $this->routeLevels = $this->segmentCount > 2 ? 2 : 1;
        $this->className = $this->segmentCount >= 3 ? "{$uriSegments[0]}{$uriSegments[2]}" : $uriSegments[0];
        $this->routeName = $this->segmentCount >= 3
            ? strtolower("{$uriSegments[0]}.{$uriSegments[2]}")
            : strtolower($uriSegments[0]);
        if ($this->segmentCount >= 2) {
            $this->param1 = $uriSegments[1];
        }
        if ($this->segmentCount >= 4) {
            $this->param2 = $uriSegments[3];
        }
        $this->indexRoute = in_array($this->segmentCount, [1,3]);
    }

    private function assertSegmentLength(): void
    {
        $verb = $this->getVerb();
        if ($this->segmentCount > 4 || $this->segmentCount === 0) {
            throw new InvalidRouteException($verb, $this->getUriPath(), "Routes must contain between 1 and 4 segments. Actual: {$this->segmentCount}.");
        }
        switch ($verb) {
            case 'POST':
                if ($this->routeLevels === 2 && $this->segmentCount != 3) {
                    throw new InvalidRouteException($verb, $this->getUriPath(), "POST calls to child objects must contain 3 segments.");
                }
                if ($this->routeLevels === 1 && $this->segmentCount != 1) {
                    throw new InvalidRouteException($verb, $this->getUriPath(), "POST calls to parent objects must contain 1 segments.");
                }
                break;
            case 'PUT':
            case 'DELETE':
                if ($this->routeLevels === 2 &&  $this->segmentCount != 4) {
                    throw new InvalidRouteException($verb, $this->getUriPath(), "$verb calls to child objects must contain 4 segments.");
                }
                if ($this->routeLevels === 1 && $this->segmentCount != 2) {
                    throw new InvalidRouteException($verb, $this->getUriPath(), "$verb calls to parent objects must contain 2 segments.");
                }
                break;
        }
    }

    /**
     * @return ControllerInterface
     * @throws InvalidRouteException
     */
    public function getController(): ControllerInterface
    {
        if (! $this->hasController()) {
            throw new ControllerNotFoundException(self::$controllerRoot. '\\' . $this->className);
        }
        return self::$controllers[$this->routeName];
    }

    /**
     * @return string the path part of the URI.
     */
    private function getUriPath(): string
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    /**
     * @return string the HTTP verb.
     */
    private function getVerb(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function hasController() : bool
    {
        return array_key_exists($this->routeName, self::$controllers);
    }

    public function invokeControllerMethod() : void
    {
        $this->assertSegmentLength();
        $verb = $this->getVerb();
        switch ($verb) {
            case 'GET':
                $this->invokeControllerGet();
                break;
            case 'POST':
                $this->invokeControllerPost();
                break;
            case 'PUT':
                $this->invokeControllerPut();
                break;
            case 'DELETE':
                $this->invokeControllerDelete();
                break;
            default:
                throw new UnsupportedVerbException($verb);
        }
    }

    private function invokeControllerGet() : void
    {
        $controller = $this->getController();
        $this->indexRoute ? $controller->index($this->param1) : $controller->get($this->param1, $this->param2);
    }

    private function invokeControllerPost() : void
    {
        $controller = $this->getController();
        $controller->create($this->param1);
    }

    private function invokeControllerPut() : void
    {
        $controller = $this->getController();
        $controller->update($this->param1, $this->param2);
    }

    private function invokeControllerDelete() : void
    {
        $controller = $this->getController();
        $controller->delete($this->param1, $this->param2);
    }
}
