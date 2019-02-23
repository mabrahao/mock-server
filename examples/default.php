<?php

use mabrahao\MockServer\Domain\MethodEnum;
use mabrahao\MockServer\Infrastructure\Request;
use mabrahao\MockServer\Infrastructure\Response;

require __DIR__ . '/../vendor/autoload.php';

$server = new \mabrahao\MockServer\MockServer('127.0.0.1', 64648);
$server->run();

$server->when(
    (new Request())
        ->withPath('/api/v1/integrations')
        ->withMethod(MethodEnum::POST)
        ->withHeader('content-type', 'application/json')
        ->withHeader('x-api-key', 'FAKE_KEY')
        ->withBody(json_encode(['key'=>'value']))
)->respond(
    (new Response())
        ->withStatusCode(201)
        ->withHeader('Content-Type', 'application/json')
        ->withBody(json_encode(['integrations' => ['MB','LS']]))
);