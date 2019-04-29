<?php

namespace Router;

use UnexpectedValueException;

class InvalidControllerException extends UnexpectedValueException
{
    public function __construct(string $controllerName)
    {
        parent::__construct("Controller $controllerName does not implement ControllerInterface.");
    }
}
