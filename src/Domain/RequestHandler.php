<?php

namespace mabrahao\MockServer\Domain;

interface RequestHandler
{
    public function respond(Response $response);
}