<?php

namespace mabrahao\MockServer\Infrastructure;

use mabrahao\MockServer\Domain\RequestInterface;
use mabrahao\MockServer\Domain\RequestHandlerInterface;
use mabrahao\MockServer\Domain\ResponseInterface;

class RequestHandler implements RequestHandlerInterface
{
    /** @var RequestInterface */
    private $request;

    /**
     * DefaultRequestMatcher constructor.
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function respond(ResponseInterface $response)
    {
        $matchConfig = [
            'request' => $this->request->getConfigs(),
            'response' => $response->getConfigs(),
        ];

        $tmpDir = sys_get_temp_dir() ?: '/tmp';

        $file = fopen($tmpDir . DIRECTORY_SEPARATOR . "request.config", "w");
        fwrite($file, json_encode($matchConfig));
        fclose($file);
    }
}
