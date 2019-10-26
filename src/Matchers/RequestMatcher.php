<?php

namespace mabrahao\MockServer\Matchers;

use mabrahao\MockServer\Model\Expectation;
use mabrahao\MockServer\Matchers\Body\BodyMatcher;
use mabrahao\MockServer\Matchers\Header\HeaderMatcher;
use mabrahao\MockServer\Matchers\Method\MethodMatcher;
use mabrahao\MockServer\Matchers\Path\PathMatcher;

class RequestMatcher
{
    /** @var PathMatcher */
    private $pathMatcher;
    /** @var MethodMatcher */
    private $methodMatcher;
    /** @var BodyMatcher */
    private $bodyMatcher;
    /** @var HeaderMatcher */
    private $headerMatcher;

    /**
     * RequestMatcher constructor.
     * @param PathMatcher $pathMatcher
     * @param MethodMatcher $methodMatcher
     * @param BodyMatcher $bodyMatcher
     * @param HeaderMatcher $headerMatcher
     */
    public function __construct(
        PathMatcher $pathMatcher,
        MethodMatcher $methodMatcher,
        BodyMatcher $bodyMatcher,
        HeaderMatcher $headerMatcher
    ) {
        $this->pathMatcher = $pathMatcher;
        $this->methodMatcher = $methodMatcher;
        $this->bodyMatcher = $bodyMatcher;
        $this->headerMatcher = $headerMatcher;
    }

    public function matches(Expectation $expectation, $serverData, $inputData): bool
    {
        $expectationPath = $serverData['REQUEST_URI'];
        $pathCondition = $expectation->getRequest()->getPath();
        if (!$this->pathMatcher->matches($expectationPath, $pathCondition)) {
            return false;
        }

        $expectationMethod = $serverData['REQUEST_METHOD'];
        $methodCondition = $expectation->getRequest()->getMethod();
        if (!$this->methodMatcher->matches($expectationMethod, $methodCondition)) {
            return false;
        }

        $expectationBody = $expectation->getRequest()->getBody();
        $bodyCondition = $inputData;
        if ($expectationBody && !$this->bodyMatcher->matches($expectationBody, $bodyCondition)) {
            return false;
        }

        $expectationHeaders = $expectation->getRequest()->getHeaders();
        if ($expectationHeaders && !$this->headerMatcher->matches($expectationHeaders, $serverData)) {
            return false;
        }

        return true;
    }
}
