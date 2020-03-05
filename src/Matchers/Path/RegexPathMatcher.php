<?php

namespace Mabrahao\MockServer\Matchers\Path;

class RegexPathMatcher implements PathMatcherInterface
{
    /** @var PathMatcherInterface */
    private $nextMatcher;

    /**
     * PathRegexMatcher constructor.
     * @param PathMatcherInterface $nextMatcher
     */
    public function __construct(PathMatcherInterface $nextMatcher)
    {
        $this->nextMatcher = $nextMatcher;
    }

    public function matches(string $actual, string $condition): bool
    {
        if ($this->matchRegex($actual, $condition)) {
            return true;
        }

        return $this->nextMatcher->matches($actual, $condition);
    }

    private function matchRegex(string $actual, string $condition)
    {
        $old_error = error_reporting(0);
        $result = preg_match($condition, $actual);
        error_reporting($old_error);

        return $result;
    }
}
