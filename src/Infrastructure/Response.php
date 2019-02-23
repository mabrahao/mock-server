<?php

namespace mabrahao\MockServer\Infrastructure;

use mabrahao\MockServer\Domain\ResponseInterface;

class Response implements ResponseInterface
{
    private $responseStructure;

    /**
     * @param int $statusCode
     * @return ResponseInterface
     */
    public function withStatusCode(int $statusCode): ResponseInterface
    {
        $this->responseStructure['statusCode'] = $statusCode;
        return $this;
    }

    /**
     * @param string $headerKey
     * @param string $headerValue
     * @return ResponseInterface
     */
    public function withHeader(string $headerKey, string $headerValue): ResponseInterface
    {
        $this->responseStructure['header'] = array_merge(
            $this->responseStructure['header'] ?? [],
            [$headerKey => $headerValue]
        );
        return $this;
    }

    /**
     * @param string $cookieKey
     * @param string $cookieValue
     * @return ResponseInterface
     */
    public function withCookie(string $cookieKey, string $cookieValue): ResponseInterface
    {
        $this->responseStructure['cookie'] = array_merge(
            $this->responseStructure['cookie'] ?? [],
            [$cookieKey => $cookieValue]
        );
        return $this;
    }

    /**
     * @param string $body
     * @return ResponseInterface
     */
    public function withBody(string $body): ResponseInterface
    {
        $this->responseStructure['body'] = $body;
        return $this;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->responseStructure;
    }
}
