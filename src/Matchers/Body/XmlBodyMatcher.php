<?php

namespace mabrahao\MockServer\Matchers\Body;

class XmlBodyMatcher implements BodyMatcherInterface
{
    /** @var BodyMatcherInterface */
    private $nextMatcher;

    public function __construct(BodyMatcherInterface $nextMatcher)
    {
        $this->nextMatcher = $nextMatcher;
    }

    public function matches($actual, $condition): bool
    {
        // TODO: implement verification
        return $this->nextMatcher->matches($actual, $condition);
    }
}
