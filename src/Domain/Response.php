<?php

namespace mabrahao\MockServer\Domain;

interface Response
{
    public function withStatusCode(int $statusCode): Response;
    public function withHeader(string $headerKey, string $headerValue): Response;
    public function withCookie(string $cookieKey, string $cookieValue): Response;
    public function withBody(string $body): Response;
}