<?php

namespace mabrahao\MockServer\Model;

class Request
{
    private $requestStructure = [];

    /**
     * Request constructor.
     * @param array $requestStructure
     */
    private function __construct(array $requestStructure = [])
    {
        $this->requestStructure = $requestStructure;
    }


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
     * @param string $body
     * @return Request
     */
    public function withJsonBody(string $body): Request
    {
        $this->requestStructure['jsonBody'] = $body;
        return $this;
    }

    public function getPath(): string
    {
        return $this->requestStructure['path'];
    }

    public function getMethod(): string
    {
        return $this->requestStructure['method'];
    }

    public function getBody(): ?string
    {
        return $this->requestStructure['body'] ?? null;
    }

    public function getHeaders(): ?array
    {
        return $this->requestStructure['header'] ?? null;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->requestStructure;
    }

    public static function fromArray(array $requestStructure): self
    {
        return new self($requestStructure);
    }

    public static function new(): self
    {
        return new self();
    }
}
