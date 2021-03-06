<?php

namespace Mabrahao\MockServer;

use Mabrahao\MockServer\Model\Expectation;

class ResponseBuilder
{
    public function buildFrom(Expectation $expectation)
    {
        $response = $expectation->getResponse()->toArray();

        $statusCode = $response['statusCode'] ?? 200;
        $body = $response['body'];

        if (isset($response['header']) && count($response['header']) > 0) {
            foreach ($response['header'] as $key => $value) {
                header("{$key}: {$value}");
            }
        }

        if (isset($response['cookie']) && count($response['cookie']) > 0) {
            foreach ($response['cookie'] as $key => $value) {
                setcookie($key, $value);
            }
        }

        http_response_code($statusCode);
        echo $body;
    }
}
