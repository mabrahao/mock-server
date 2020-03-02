<?php

namespace mabrahao\MockServer\Matchers\Body;

use mabrahao\MockServer\Model\Body;

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
                new ParameterBodyMatcher(
                    new JsonBodyMatcher(
                        new NotFoundBodyMatcher()
                    )
                )
            )
        );
    }

    public function matches($actual, Body $condition): bool
    {
        return $this->matchersChain->matches($actual, $condition);
    }
}
