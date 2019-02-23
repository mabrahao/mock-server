<?php

namespace mabrahao\MockServer\Domain;

interface RequestMatcher
{
    public function respond(Response $response);
}