<?php

namespace mabrahao\MockServer\Infrastructure;

use mabrahao\MockServer\Domain\RequestInterface;
use mabrahao\MockServer\Domain\RequestHandlerInterface;
use mabrahao\MockServer\Domain\ResponseInterface;

class TmpFileRequestHandler implements RequestHandlerInterface
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

        $tmpPath = $tmpDir . DIRECTORY_SEPARATOR . 'mock-server';

        if(!is_dir($tmpPath)) {
            echo $tmpPath . PHP_EOL;
            mkdir($tmpPath);
        }

        $uniqid = uniqid('request-');
        $filePath = $tmpPath . DIRECTORY_SEPARATOR . "{$uniqid}.config";

        $file = fopen($filePath, "w");
        fwrite($file, json_encode($matchConfig));
        fclose($file);
    }
}
