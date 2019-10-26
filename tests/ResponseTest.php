<?php

use mabrahao\MockServer\Response\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testConfigs()
    {
        // setup
        $statusCode = 200;
        $headerKey = 'content-type';
        $headerValue = 'application/json';
        $otherHeaderKey = 'x-api-key';
        $otherHeaderValue = 'fake_key';
        $cookieKey = 'TOKEN';
        $cookieValue = 'FAKE_TOKEN';
        $body = json_encode(['key'=>'value']);

        $expected = [
            'statusCode' => $statusCode,
            'header' => [
                $headerKey => $headerValue,
                $otherHeaderKey => $otherHeaderValue
            ],
            'cookie' => [
                $cookieKey => $cookieValue
            ],
            'body' => $body,
        ];

        $response = Response::new()
            ->withStatusCode($statusCode)
            ->withHeader($headerKey, $headerValue)
            ->withHeader($otherHeaderKey, $otherHeaderValue)
            ->withCookie($cookieKey, $cookieValue)
            ->withBody($body);

        // execution
        $actual = $response->toArray();

        // assertions
        $this->assertEquals($expected, $actual);
    }
}
