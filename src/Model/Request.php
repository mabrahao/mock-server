<?php

namespace Mabrahao\MockServer\Model;

class Request
{
    /** @var Body */
    private $body;
    /** @var string */
    private $path;
    /** @var string */
    private $method;
    /** @var array|null */
    private $headers;

    /**
     * Request constructor.
     * @param string $path
     * @param string $method
     * @param Body|null $body
     * @param array|null $headers
     */
    private function __construct(?string $path, ?string $method, ?Body $body, ?array $headers)
    {
        $this->path = $path;
        $this->method = $method;
        $this->body = $body;
        $this->headers = $headers;
    }


    /**
     * @param string $path
     * @return Request
     */
    public function withPath(string $path): Request
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param string $method
     * @return Request
     */
    public function withMethod(string $method): Request
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $headerKey
     * @param string $headerValue
     * @return Request
     */
    public function withHeader(string $headerKey, string $headerValue): Request
    {
        $this->headers = array_merge(
            $this->headers ?? [],
            [$headerKey => $headerValue]
        );
        return $this;
    }

    /**
     * @param $body
     * @return Request
     */
    public function withBody($body): Request
    {
        if (is_string($body)) {
            $body = new StringBody($body);
        }

        $this->body = $body;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getBody(): ?Body
    {
        return $this->body ?? null;
    }

    public function getHeaders(): ?array
    {
        return $this->headers ?? null;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'path' => $this->path,
            'method' => $this->method,
            'body' => serialize($this->body),
            'headers' => $this->headers,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['path'],
            $data['method'],
            unserialize($data['body']) ?? null,
            $data['headers'] ?? null
        );
    }

    public static function new(): self
    {
        return new self(null, null, null, null);
    }
}
