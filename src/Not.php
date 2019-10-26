<?php

namespace mabrahao\MockServer;

class Not
{
    private $expectation;

    /**
     * Not constructor.
     * @param $expectation
     */
    public function __construct($expectation)
    {
        $this->expectation = $expectation;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }
}
