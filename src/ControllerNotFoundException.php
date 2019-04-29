<?php

namespace Router;

use UnexpectedValueException;

class ControllerNotFoundException extends UnexpectedValueException
{
    public function __construct(string $controllerName)
    {
        parent::__construct("Controller $controllerName not found.");
    }
}
