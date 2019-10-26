<?php

namespace mabrahao\MockServer\Matchers\Method;

class MethodMatcher implements MethodMatcherInterface
{
    /** @var MethodMatcherInterface */
    private $matchersChain;

    /**
     * MethodMatcher constructor.
     */
    public function __construct()
    {
        $this->matchersChain = new StringMethodMatcher(
            new NotFoundMethodMatcher()
        );
    }

    public function matches(string $actual, string $condition): bool
    {
        return $this->matchersChain->matches($actual, $condition);
    }
}
