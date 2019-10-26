<?php

namespace mabrahao\MockServer;

use mabrahao\MockServer\Request\Request;

class MockServerClient
{
    /** @var MockServer */
    private $server;
    /** @var ExpectationRepository */
    private $expectationRepository;

    /**
     * MockServer constructor.
     * @param string $host
     * @param int $port
     * @param int $sleepTime
     * @param string $storageType
     */
    public function __construct(string $host = '127.0.0.1', int $port = 0, $sleepTime = 200000, $storageType = Storage::TEMP_FILE)
    {
        $this->server = ServerFactory::newInstance($host, $port, $sleepTime, $storageType);
        $this->expectationRepository = ExpectationRepositoryFactory::newInstance($storageType);
    }

    public function when(Request $request, Times $times = null): ChainExpectation
    {
        if (!$this->server->isRunning()) {
            $this->server->run();
        }

        $expectation = new Expectation($request, $times);

        return new ChainExpectation($this, $expectation);
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
        return $this->server->getUrl();
    }

    public function __destruct()
    {
        $this->expectationRepository->nukeAllExpectations();
        $this->server->stop();
    }
}
