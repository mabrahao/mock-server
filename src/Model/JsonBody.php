<?php

namespace mabrahao\MockServer\Model;

use mabrahao\MockServer\Enum\MatchType;

class JsonBody extends Body
{
    /** @var string */
    private $body;
    /** @var MatchType */
    private $matchType;

    /**
     * JsonBody constructor.
     * @param string $body
     * @param MatchType|null $matchType
     */
    public function __construct(string $body, MatchType $matchType = null)
    {
        $this->body = $body;
        $this->matchType = $matchType ?? MatchType::STRICT();
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return MatchType
     */
    public function getMatchType(): MatchType
    {
        return $this->matchType;
    }

    public function __toString()
    {
        return $this->body;
    }
}