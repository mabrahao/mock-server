<?php

namespace mabrahao\MockServer\Domain;

interface Request
{
    public function withPath(string $path): Request;
    public function withMethod(MethodEnum $method): Request;
    public function withHeader(string $headerKey, string $headerValue): Request;
    public function withBody(string $body): Request;
}