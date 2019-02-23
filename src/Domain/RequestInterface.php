<?php

namespace mabrahao\MockServer\Domain;

interface RequestInterface
{
    public function withPath(string $path): RequestInterface;
    public function withMethod(string $method): RequestInterface;
    public function withHeader(string $headerKey, string $headerValue): RequestInterface;
    public function withBody(string $body): RequestInterface;
    public function getConfigs(): array;
}