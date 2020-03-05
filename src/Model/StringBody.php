<?php

namespace Mabrahao\MockServer\Model;

class StringBody extends Body
{
    /** @var string */
    private $body;

    /**
     * StringBody constructor.
     * @param string $body
     */
    public function __construct(string $body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    public function __toString()
    {
        return $this->body;
    }
}
