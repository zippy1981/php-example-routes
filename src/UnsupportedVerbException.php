<?php

namespace Router;

use UnexpectedValueException;

class UnsupportedVerbException extends UnexpectedValueException
{
    public function __construct(string $verbName)
    {
        parent::__construct("Unsupported Verb $verbName.");
    }
}
