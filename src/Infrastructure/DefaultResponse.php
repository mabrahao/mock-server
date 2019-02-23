<?php

namespace mabrahao\MockServer\Infrastructure;

use mabrahao\MockServer\Domain\Response;

class DefaultResponse implements Response
{
    private $responseStructure;

    /**
     * @param int $statusCode
     * @return Response
     */
    public function withStatusCode(int $statusCode): Response
    {
        $this->responseStructure['statusCode'] = $statusCode;
        return $this;
    }

    /**
     * @param string $headerKey
     * @param string $headerValue
     * @return Response
     */
    public function withHeader(string $headerKey, string $headerValue): Response
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
     * @return Response
     */
    public function withCookie(string $cookieKey, string $cookieValue): Response
    {
        $this->responseStructure['cookie'] = array_merge(
            $this->responseStructure['cookie'] ?? [],
            [$cookieKey => $cookieValue]
        );
        return $this;
    }

    /**
     * @param string $body
     * @return Response
     */
    public function withBody(string $body): Response
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
