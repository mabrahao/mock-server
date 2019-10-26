<?php

namespace mabrahao\MockServer\Model;

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
     */
    public function __construct(Request $request, Times $times = null)
    {
        if (!$times) {
            $times = Times::any();
        }

        $this->request = $request;
        $this->times = $times;
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
            'times' => $this->times->getRemaining(),
            'response' => $this->response->toArray()
        ];
    }
}
