<?php

namespace mabrahao\MockServer;

use mabrahao\MockServer\Model\Expectation;
use mabrahao\MockServer\Model\Response;

class ChainedExpectation
{
    /** @var MockServerClient */
    private $mockServerClient;
    /** @var Expectation */
    private $expectation;

    /**
     * DefaultRequestMatcher constructor.
     * @param MockServerClient $mockServerClient
     * @param Expectation $expectation
     */
    public function __construct(MockServerClient $mockServerClient, Expectation $expectation)
    {
        $this->expectation = $expectation;
        $this->mockServerClient = $mockServerClient;
    }

    /**
     * @param Response $response
     */
    public function respond(Response $response)
    {
        $this->expectation->setResponse($response);
        $this->mockServerClient->storeChainedExpectation($this->expectation);
    }
}
