<?php


namespace Mabrahao\MockServer\Model;


use Mabrahao\MockServer\Enum\MatchType;

class Body
{
    public static function string(string $body): StringBody
    {
        return new StringBody($body);
    }

    public static function json(string $body, MatchType $matchType = null): JsonBody
    {
        return new JsonBody($body, $matchType);
    }

    public static function params(Param ...$params): ParameterBody
    {
        return new ParameterBody($params);
    }
}