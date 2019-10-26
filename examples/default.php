<?php

require __DIR__ . '/../vendor/autoload.php';

use mabrahao\MockServer\Enum\Method;
use mabrahao\MockServer\Request\Request;
use mabrahao\MockServer\Response\Response;
use mabrahao\MockServer\MockServerClient;

$server = new MockServerClient('127.0.0.1', 64648);

$server->when(
    Request::new()
        ->withPath('/api/v1/integrations')
        ->withMethod(Method::GET)
)->respond(
    Response::new()
        ->withStatusCode(200)
        ->withHeader('Content-Type', 'application/json')
        ->withBody(json_encode(['integrations' => ['MB','LS']]))
);

$server->when(
    Request::new()
        ->withPath('/api/v1/integrations')
        ->withMethod(Method::POST)
        ->withBody(json_encode(['name' => 'John Doe', 'email' => 'john.doe@7shifts.com']))
)->respond(
    Response::new()
        ->withStatusCode(201)
        ->withHeader('Content-Type', 'application/json')
        ->withBody(json_encode(['success' => true]))
);

$server->when(
    Request::new()
        ->withPath('/\/api\/v1\/integrations\/\d$/')
        ->withMethod(Method::GET)
)->respond(
    Response::new()
        ->withStatusCode(201)
        ->withHeader('Content-Type', 'application/json')
        ->withBody(json_encode(['name' => 'John Doe', 'email' => 'john.doe@7shifts.com']))
);


while (true);