<?php

namespace Mabrahao\MockServer;

use Mabrahao\MockServer\ExpectationRepository\ExpectationRepositoryInterface;
use Mabrahao\MockServer\Model\Expectation;
use Mabrahao\MockServer\Model\Times;
use Mabrahao\MockServer\Model\Request;

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

        $expectation = new Expectation(null, $request, $times);

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
        $expectations = $this->expectationRepository->fetchAll();
        $this->expectationRepository->nukeAllExpectations();
        $this->mockServer->stop();
        $this->checkCallsExpectations($expectations);
    }

    /**
     * @param Expectation[] $expectations
     */
    private function checkCallsExpectations(array $expectations): void
    {
        array_walk($expectations, function(Expectation $expectation) {
            $expectation->checkCallsExpectation();
        });
    }
}
