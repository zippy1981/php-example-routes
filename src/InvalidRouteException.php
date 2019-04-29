<?php

namespace Router;

use UnexpectedValueException;

class InvalidRouteException extends UnexpectedValueException
{
    public function __construct(string $verb, string $urlSegment)
    {
        parent::__construct("$verb $urlSegment is not a valid route.");
    }
}
