<?php

namespace mabrahao\MockServer\Matchers\Path;

class PathMatcher implements PathMatcherInterface
{
    /** @var PathMatcherInterface */
    private $matchersChain;

    /**
     * PathMatcher constructor.
     */
    public function __construct()
    {
        $this->matchersChain = new StringPathMatcher(
            new RegexPathMatcher(
                new NotFoundPathMatcher()
            )
        );
    }

    public function matches(string $actual, string $condition): bool
    {
        return $this->matchersChain->matches($actual, $condition);
    }
}
