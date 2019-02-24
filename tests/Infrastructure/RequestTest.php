<?php

use mabrahao\MockServer\Domain\MethodEnum;
use mabrahao\MockServer\Infrastructure\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testConfigs()
    {
        // setup
        $path = '/fake/path';
        $method = MethodEnum::POST;
        $headerKey = 'content-type';
        $headerValue = 'application/json';
        $otherHeaderKey = 'x-api-key';
        $otherHeaderValue = 'fake_key';
        $body = json_encode(['key'=>'value']);

        $expected = [
            'path' => $path,
            'method' => $method,
            'header' => [
                $headerKey => $headerValue,
                $otherHeaderKey => $otherHeaderValue
            ],
            'body' => $body,
        ];

        $request = new Request();
        $request
            ->withPath($path)
            ->withMethod($method)
            ->withHeader($headerKey, $headerValue)
            ->withHeader($otherHeaderKey, $otherHeaderValue)
            ->withBody($body);

        // execution
        $actual = $request->getConfigs();

        // assertions
        $this->assertEquals($expected, $actual);
    }
}
