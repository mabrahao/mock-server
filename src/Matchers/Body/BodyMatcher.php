<?php

namespace mabrahao\MockServer\Matchers\Body;

class BodyMatcher implements BodyMatcherInterface
{
    /** @var BodyMatcherInterface */
    private $matchersChain;

    /**
     * BodyMatcher constructor.
     */
    public function __construct()
    {
        $this->matchersChain = new StringBodyMatcher(
            new RegexBodyMatcher(
                new JsonBodyMatcher(
                    new NotFoundBodyMatcher()
                )
            )
        );
    }

    public function matches($actual, $condition): bool
    {
        return $this->matchersChain->matches($actual, $condition);
    }
}
