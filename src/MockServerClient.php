<?php

namespace mabrahao\MockServer;

use mabrahao\MockServer\ExpectationRepository\ExpectationRepositoryInterface;
use mabrahao\MockServer\Model\Expectation;
use mabrahao\MockServer\Model\Times;
use mabrahao\MockServer\Model\Request;

class MockServerClient
{
    /** @var MockServer */
    private $mockServer;
    /** @var ExpectationRepositoryInterface */
    private $expectationRepository;

    /**
     * MockServerClient constructor.
     * @param MockServer $mockServer
     * @param ExpectationRepositoryInterface $expectationRepository
     */
    public function __construct(MockServer $mockServer, ExpectationRepositoryInterface $expectationRepository)
    {
        $this->mockServer = $mockServer;
        $this->expectationRepository = $expectationRepository;
    }

    public function when(Request $request, Times $times = null): ChainedExpectation
    {
        if (!$this->mockServer->isRunning()) {
            $this->mockServer->run();
        }

        $expectation = new Expectation($request, $times);

        return new ChainedExpectation($this, $expectation);
    }

    public function storeChainedExpectation(Expectation $expectation)
    {
        $this->expectationRepository->store($expectation);
    }

    /**
     * @return string
     */
    public function getServerUrl(): string
    {
        return $this->mockServer->getUrl();
    }

    public function __destruct()
    {
        // TODO: Throw exception if a expectation is set to not any and counter in less than expected
        $this->expectationRepository->nukeAllExpectations();
        $this->mockServer->stop();
    }
}
