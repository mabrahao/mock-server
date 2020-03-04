<?php

namespace mabrahao\MockServer\Model;

use mabrahao\MockServer\Exceptions\TooFewCallsException;
use mabrahao\MockServer\Exceptions\TooManyCallsException;
use mabrahao\MockServer\Model\Request;
use mabrahao\MockServer\Model\Response;
use mabrahao\MockServer\Model\Times;

class Expectation
{
    /** @var Request */
    private $request;
    /** @var Times */
    private $times;
    /** @var Response */
    private $response;

    /**
     * Expectation constructor.
     * @param Request $request
     * @param Times $times
     * @param \mabrahao\MockServer\Model\Response|null $response
     */
    public function __construct(Request $request, Times $times = null, Response $response = null)
    {
        if (!$times) {
            $times = Times::any();
        }

        $this->request = $request;
        $this->times = $times;
        $this->response = $response;
    }

    public function setResponse(Response $response): Expectation
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Times
     */
    public function getTimes(): Times
    {
        return $this->times;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    public function toArray(): array
    {
        return [
            'request' => $this->request->toArray(),
            'times' => $this->times->toArray(),
            'response' => $this->response->toArray()
        ];
    }

    public function incrementCalls()
    {
        $this->times->incrementActual();
    }

    public function checkCallsExpectation(): void
    {
        $path = $this->getRequest()->getPath();
        $times = $this->getTimes();
        if (!$times->matchesExpectation()) {
            $message = sprintf(
                "Path: %s set to be called %d %s, but was called %d %s",
                $path,
                $times->getExpectedAmount(),
                $times->getExpectedAmount() === 1 ? 'time' : 'times',
                $times->getActualAmount(),
                $times->getActualAmount() === 1 ? 'time' : 'times'
            );

            if ($times->getExpectedAmount() < $times->getActualAmount()) {
                throw new TooManyCallsException($message);
            }

            throw new TooFewCallsException($message);
        }
    }
}
