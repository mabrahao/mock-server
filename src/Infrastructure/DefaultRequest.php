<?php

namespace mabrahao\MockServer\Infrastructure;

use mabrahao\MockServer\Domain\Request;

class DefaultRequest implements Request
{
    private $requestStructure = [];

    /**
     * @param string $path
     * @return Request
     */
    public function withPath(string $path): Request
    {
        $this->requestStructure['path'] = $path;
        return $this;
    }

    /**
     * @param string $method
     * @return Request
     */
    public function withMethod(string $method): Request
    {
        $this->requestStructure['method'] = $method;
        return $this;
    }

    /**
     * @param string $headerKey
     * @param string $headerValue
     * @return Request
     */
    public function withHeader(string $headerKey, string $headerValue): Request
    {
        $this->requestStructure['header'] = array_merge(
            $this->requestStructure['header'] ?? [],
            [$headerKey => $headerValue]
        );
        return $this;
    }

    /**
     * @param string $body
     * @return Request
     */
    public function withBody(string $body): Request
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
