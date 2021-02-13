<?php

namespace Router;

use UnexpectedValueException;

class InvalidRouteException extends UnexpectedValueException
{
    /**
     * @var string The reason the route is invalid
     */
    private $reason;

    public function __construct(string $verb, string $urlSegment, string $reason)
    {
        $this->reason = $reason;
        parent::__construct("$verb $urlSegment is not a valid route.\nReason: $reason");
    }

    public function getReason() :string
    {
        return $this->reason();
    }
}
