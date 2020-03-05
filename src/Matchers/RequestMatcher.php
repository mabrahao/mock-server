<?php

namespace Mabrahao\MockServer\Matchers;

use Mabrahao\MockServer\Model\Expectation;
use Mabrahao\MockServer\Matchers\Body\BodyMatcher;
use Mabrahao\MockServer\Matchers\Header\HeaderMatcher;
use Mabrahao\MockServer\Matchers\Method\MethodMatcher;
use Mabrahao\MockServer\Matchers\Path\PathMatcher;

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

    public function matches(Expectation $expectation, $serverData, $formData, $inputData): bool
    {
        $pathExpectation = $serverData['REQUEST_URI'];
        $pathCondition = $expectation->getRequest()->getPath();
        if (!$this->pathMatcher->matches($pathExpectation, $pathCondition)) {
            return false;
        }

        $methodExpectation = $serverData['REQUEST_METHOD'];
        $methodCondition = $expectation->getRequest()->getMethod();
        if (!$this->methodMatcher->matches($methodExpectation, $methodCondition)) {
            return false;
        }

        $bodyExpectation = $this->getBodyExpectation($formData, $inputData);
        $bodyCondition = $expectation->getRequest()->getBody();
        if ($bodyCondition && !$this->bodyMatcher->matches($bodyExpectation, $bodyCondition)) {
            return false;
        }

        $headerCondition = $expectation->getRequest()->getHeaders();
        if ($headerCondition && !$this->headerMatcher->matches($headerCondition, $serverData)) {
            return false;
        }

        return true;
    }

    private function getBodyExpectation($formData, $inputData): string
    {
        if ($formData) {
            return $this->getStringifiedFormData($formData);
        }

        return $inputData;
    }

    private function getStringifiedFormData($formData): string
    {
        ksort($formData);
        return implode(
            "&",
            array_map(
                function ($value, $key) {
                    return sprintf("%s=%s", strval($key), $value);
                },
                $formData,
                array_keys($formData)
            )
        );
    }
}
