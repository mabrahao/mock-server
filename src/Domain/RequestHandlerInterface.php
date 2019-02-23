<?php

namespace mabrahao\MockServer\Domain;

interface RequestHandlerInterface
{
    public function respond(ResponseInterface $response);
}