<?php

namespace mabrahao\MockServer\Infrastructure;

use mabrahao\MockServer\Domain\Request;
use mabrahao\MockServer\Domain\RequestHandler;
use mabrahao\MockServer\Domain\Response;

class DefaultRequestHandler implements RequestHandler
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
