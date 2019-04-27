<?php
namespace Router;

class Router
{
    public function getRoute(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getVerb(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
