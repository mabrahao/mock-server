<?php

namespace mabrahao\MockServer\Matchers\Body;

use mabrahao\MockServer\Enum\MatchType;
use mabrahao\MockServer\Model\Body;
use mabrahao\MockServer\Model\JsonBody;

class JsonBodyMatcher implements BodyMatcherInterface
{
    /** @var BodyMatcherInterface */
    private $nextMatcher;

    public function __construct(BodyMatcherInterface $nextMatcher)
    {
        $this->nextMatcher = $nextMatcher;
    }

    public function matches($actual, Body $condition): bool
    {
        if ($condition instanceof JsonBody) {
            /** @var JsonBody */
            $matchType = $condition->getMatchType();
            switch ($matchType) {
                case MatchType::CONTAINS():
                    return $this->matchContains($actual, $condition);
                case MatchType::STRICT():
                default:
                    return $this->matchStrict($actual, $condition);
            }
        }

        if (json_decode($actual) == json_decode($condition)) {
            return true;
        }

        return $this->nextMatcher->matches($actual, $condition);
    }

    private function matchContains($actual, JsonBody $condition)
    {
        $a = json_decode($actual, true);
        $c = json_decode($condition, true);
        return count(array_intersect($c, $a)) === count($c);
    }

    private function matchStrict($actual, JsonBody $condition)
    {
        $a = json_decode($actual, true);
        $c = json_decode($condition, true);

        ksort($a);
        ksort($c);

        return $a === $c;
    }
}
