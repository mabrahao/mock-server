<?php

require __DIR__ . '/../vendor/autoload.php';

use Mabrahao\MockServer\Enum\MatchType;
use Mabrahao\MockServer\Enum\Method;
use Mabrahao\MockServer\MockServerBuilder;
use Mabrahao\MockServer\Model\Body;
use Mabrahao\MockServer\Model\Param;
use Mabrahao\MockServer\Model\Request;
use Mabrahao\MockServer\Model\Response;
use Mabrahao\MockServer\Model\Times;

$server = MockServerBuilder::build('127.0.0.1', 64648);

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
        ->withBody(
            Body::json(
                json_encode(['name' => 'Maria Doe']),
                MatchType::STRICT()
            )
        )
)->respond(
    Response::new()
        ->withStatusCode(201)
        ->withHeader('Content-Type', 'application/json')
        ->withBody(json_encode(['success' => true]))
);

$server->when(
    Request::new()
        ->withPath('/api/v1/integrations')
        ->withMethod(Method::POST)
        ->withBody(
            Body::json(
                json_encode(['name' => 'John Doe']),
                MatchType::CONTAINS()
            )
        ),
    Times::once()
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

$server->when(
    Request::new()
        ->withPath('/api/v1/auth')
        ->withMethod(Method::POST)
        ->withBody(
            Body::params(
                Param::new("client_id", "4361b13c-f570-4740-8a22-1973164c217f"),
                Param::new("client_secret", "45da8b72-28f9-4faa-8d19-f018748bc965")
            )
        ),
    Times::once()
)->respond(
    Response::new()
        ->withStatusCode(201)
        ->withHeader('Content-Type', 'application/json')
        ->withBody(json_encode(['success' => false]))
);

sleep(30);