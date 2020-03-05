<?php

namespace Mabrahao\MockServer\Matchers\Body;

use Mabrahao\MockServer\Model\Body;

class RegexBodyMatcher implements BodyMatcherInterface
{
    /** @var BodyMatcherInterface */
    private $nextMatcher;

    public function __construct(BodyMatcherInterface $nextMatcher)
    {
        $this->nextMatcher = $nextMatcher;
    }

    public function matches($actual, Body $condition): bool
    {
        if ($this->matchRegex($actual, $condition)) {
            return true;
        }

        return $this->nextMatcher->matches($actual, $condition);
    }

    private function matchRegex($actual, $condition)
    {
        $old_error = error_reporting(0);
        $result = preg_match($condition, $actual);
        error_reporting($old_error);

        return $result;
    }
}
