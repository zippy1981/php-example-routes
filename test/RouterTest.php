<?php
declare(strict_types=1);

namespace Router;

use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    public function setUp(): void
    {
        Router::setControllerRoot('Router\ExampleControllers');
        Router::resource('whatever');
        Router::resource('whatever.whenever');
        parent::setUp();
    }

    public function testAddBadRoute()
    {
        $this->expectException(ControllerNotFoundException::class);
        $this->expectExceptionMessage('Controller Router\ExampleControllers\foobar not found.');
        Router::resource('foo.bar');
    }

    public function testGetController()
    {
        $_SERVER["REQUEST_URI"] = '/whatever/3/whenever/56?foo=bar';
        $router = new Router();
        $controller = $router->getController();
        $this->assertEquals('Router\ExampleControllers\WhateverWhenever', get_class($controller));
    }

    public function testGetControllerThrowsInvalidRouteException()
    {
        $this->expectException(ControllerNotFoundException::class);
        $this->expectExceptionMessage('Controller Router\ExampleControllers\FooBar not found.');
        $_SERVER["REQUEST_URI"] = '/Foo/3/Bar/56?foo=bar';
        $router = new Router();
        $router->getController();
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvokeControllerIndex()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER["REQUEST_URI"] = '/whatever/3/whenever/';
        $router = new Router();
        $router->invokeControllerMethod();
        $this->assertContains('Content-type: text/plain;charset=UTF-8', xdebug_get_headers());
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvokeControllerGet()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER["REQUEST_URI"] = '/whatever/3/whenever/444';
        $router = new Router();
        $router->invokeControllerMethod();
        $this->assertContains('Content-type: text/plain;charset=UTF-8', xdebug_get_headers());
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvokeControllerCreate()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER["REQUEST_URI"] = '/whatever/3/whenever';
        $router = new Router();
        $router->invokeControllerMethod();
        $this->assertContains('Content-type: text/plain;charset=UTF-8', xdebug_get_headers());
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvokeControllerUpdate()
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $_SERVER["REQUEST_URI"] = '/whatever/3/whenever/45';
        $router = new Router();
        $router->invokeControllerMethod();
        $this->assertContains('Content-type: text/plain;charset=UTF-8', xdebug_get_headers());
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvokeControllerDelete()
    {
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $_SERVER["REQUEST_URI"] = '/whatever/3/whenever/45';
        $router = new Router();
        $router->invokeControllerMethod();
        $this->assertContains('Content-type: text/plain;charset=UTF-8', xdebug_get_headers());
    }
}
