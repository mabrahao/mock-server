<?php

namespace mabrahao\MockServer\Domain;

class RequestMatcher
{
    /** @var array */
    private $config;
    /** @var array */
    private $serverData;
    /** @var array */
    private $inputData;
    /** @var array */
    private $postData;

    /**
     * RequestMatcher constructor.
     * @param array $config
     * @param array $serverData
     * @param array $inputData
     * @param array $postData
     */
    public function __construct(array $config, array $serverData, $inputData, array $postData)
    {
        $this->config = $config;
        $this->serverData = $serverData;
        $this->inputData = $inputData;
        $this->postData = $postData;
    }

    /**
     * @throws \Exception
     */
    public function match()
    {
        $request = $this->config['request'];
        $response = $this->config['response'];

        if($this->matchRequest($request)) {
          $this->buildResponse($response);
        }

        // TODO: Improve response when no match is found
    }

    private function matchRequest($request): bool
    {
        if ($request['path'] && $request['path'] !== $this->serverData['REQUEST_URI']){
            return false;
        }

        if ($request['method'] && $request['method'] !== $this->serverData['REQUEST_METHOD']){
            return false;
        }

        if ($request['body'] && $request['body'] !== $this->inputData){
            return false;
        }

        if ($request['header'] && count($request['header']) > 0){
            foreach($request['header'] as $headerKey => $headerValue) {
                $newKey = 'HTTP_'.strtoupper(str_replace([' ', '-'], '_', $headerKey));
                if (!$this->serverData[$newKey] || $this->serverData[$newKey] !== $headerValue)
                {
                    return false;
                }
            }
        }

        // TODO: Match User Agent

        // TODO: Validate post data i.e form-data($_POST)

        return true;
    }

    private function buildResponse($response)
    {
        $statusCode = $response['statusCode'] ?? 200;
        $body = $response['body'];

        if ($response['header'] && count($response['header']) > 0) {
            foreach ($response['header'] as $key => $value) {
                header("{$key}: {$value}");
            }
        }

        if ($response['cookie'] && count($response['cookie']) > 0) {
            foreach ($response['cookie'] as $key => $value) {
                setcookie($key, $value);
            }
        }

        http_response_code($statusCode);
        echo $body;
    }
}
