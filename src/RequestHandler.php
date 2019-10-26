<?php

namespace mabrahao\MockServer;

use mabrahao\MockServer\Expectation;
use mabrahao\MockServer\ExpectationRepositoryInterface;
use mabrahao\MockServer\ExpectationRepositoryFactory;
use mabrahao\MockServer\Matchers\Body\BodyMatcher;
use mabrahao\MockServer\Matchers\Header\HeaderMatcher;
use mabrahao\MockServer\Matchers\Method\MethodMatcher;
use mabrahao\MockServer\Matchers\Path\PathMatcher;
use mabrahao\MockServer\Matchers\RequestMatcher;
use mabrahao\MockServer\MatchNotFoundException;

class RequestHandler
{
    /** @var ResponseBuilder */
    private $responseBuilder;
    /** @var RequestMatcher */
    private $requestMatcher;
    /** @var \mabrahao\MockServer\ExpectationRepositoryInterface */
    private $expectationRepository;
    /** @var array */
    private $serverData;
    private $inputData;

    /**
     * RequestHandler constructor.
     * @param ResponseBuilder $responseBuilder
     * @param RequestMatcher $requestMatcher
     * @param \mabrahao\MockServer\ExpectationRepositoryInterface $expectationRepository
     * @param array $serverData
     * @param $inputData
     */
    public function __construct(
        RequestMatcher $requestMatcher,
        ResponseBuilder $responseBuilder,
        ExpectationRepositoryInterface $expectationRepository,
        array $serverData,
        $inputData
    ) {
        $this->responseBuilder = $responseBuilder;
        $this->requestMatcher = $requestMatcher;
        $this->expectationRepository = $expectationRepository;
        $this->serverData = $serverData;
        $this->inputData = $inputData;
    }

    public function dispatch()
    {
        $expectations = $this->expectationRepository->fetchAll();
        foreach($expectations as $expectation) {
            if($this->requestMatcher->matches($expectation, $this->serverData, $this->inputData)) {
                $this->responseBuilder->buildFrom($expectation);
                return true;
            }
        }

        throw new MatchNotFoundException('No match was found for this request!');
    }
}
