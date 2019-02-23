<?php

namespace mabrahao\MockServer\Infrastructure;

use mabrahao\MockServer\Domain\RequestInterface;

class Request implements RequestInterface
{
    private $requestStructure = [];

    /**
     * @param string $path
     * @return RequestInterface
     */
    public function withPath(string $path): RequestInterface
    {
        $this->requestStructure['path'] = $path;
        return $this;
    }

    /**
     * @param string $method
     * @return RequestInterface
     */
    public function withMethod(string $method): RequestInterface
    {
        $this->requestStructure['method'] = $method;
        return $this;
    }

    /**
     * @param string $headerKey
     * @param string $headerValue
     * @return RequestInterface
     */
    public function withHeader(string $headerKey, string $headerValue): RequestInterface
    {
        $this->requestStructure['header'] = array_merge(
            $this->requestStructure['header'] ?? [],
            [$headerKey => $headerValue]
        );
        return $this;
    }

    /**
     * @param string $body
     * @return RequestInterface
     */
    public function withBody(string $body): RequestInterface
    {
        $this->requestStructure['body'] = $body;
        return $this;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->requestStructure;
    }
}
