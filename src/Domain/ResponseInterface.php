<?php

namespace mabrahao\MockServer\Domain;

interface ResponseInterface
{
    public function withStatusCode(int $statusCode): ResponseInterface;
    public function withHeader(string $headerKey, string $headerValue): ResponseInterface;
    public function withCookie(string $cookieKey, string $cookieValue): ResponseInterface;
    public function withBody(string $body): ResponseInterface;
    public function getConfigs(): array;
}