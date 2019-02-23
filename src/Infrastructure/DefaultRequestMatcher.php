<?php

namespace mabrahao\MockServer\Infrastructure;

use mabrahao\MockServer\Domain\Request;
use mabrahao\MockServer\Domain\RequestMatcher;
use mabrahao\MockServer\Domain\Response;

class DefaultRequestMatcher implements RequestMatcher
{
    /** @var Request */
    private $request;

    /**
     * DefaultRequestMatcher constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function respond(Response $response)
    {
        // TODO: Implement respond() method.
    }
}
