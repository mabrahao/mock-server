<?php

namespace Mabrahao\MockServer\Matchers\Body;

use Mabrahao\MockServer\Model\Body;
use Mabrahao\MockServer\Model\ParameterBody;

class ParameterBodyMatcher implements BodyMatcherInterface
{
    /** @var BodyMatcherInterface */
    private $nextMatcher;

    public function __construct(BodyMatcherInterface $nextMatcher)
    {
        $this->nextMatcher = $nextMatcher;
    }

    public function matches($actual, Body $condition): bool
    {
        if ($condition instanceof ParameterBody) {
            if ($actual === $condition->getBody()) {
                return true;
            }
        }

        return $this->nextMatcher->matches($actual, $condition);
    }
}
