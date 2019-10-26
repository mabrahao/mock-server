<?php

namespace mabrahao\MockServer\Matchers;

use mabrahao\MockServer\Expectation;
use mabrahao\MockServer\ExpectationRepository;
use mabrahao\MockServer\ExpectationRepositoryFactory;
use mabrahao\MockServer\Matchers\Body\BodyMatcher;
use mabrahao\MockServer\Matchers\Header\HeaderMatcher;
use mabrahao\MockServer\Matchers\Method\MethodMatcher;
use mabrahao\MockServer\Matchers\Path\PathMatcher;
use mabrahao\MockServer\MatchNotFoundException;

class RequestMatcher
{
    /** @var array */
    private $serverData;
    /** @var array */
    private $postData;
    /** @var array */
    private $inputData;
    /** @var ExpectationRepository */
    private $assertionRepository;

    /**
     * RequestMatcher constructor.
     * @param string $storageType
     * @param array $serverData
     * @param array $postData
     * @param $inputData
     */
    public function __construct(string $storageType, array $serverData, array $postData, $inputData)
    {
        $this->assertionRepository = ExpectationRepositoryFactory::newInstance($storageType);
        $this->serverData = $serverData;
        $this->postData = $postData;
        $this->inputData = $inputData;
        $this->pathMatcherChain = new PathMatcher();
        $this->methodMatcherChain = new MethodMatcher();
        $this->bodyMatcherChain = new BodyMatcher();
        $this->headerMatcherChain = new HeaderMatcher();
    }

    /**
     * @param Expectation $expectation
     * @return bool
     */
    public function match(Expectation $expectation): bool
    {
        $response = $expectation->getResponse()->toArray();

        if($this->matchRequest($expectation)) {
            $this->buildResponse($response);
            return true;
        }

        return false;
        // TODO: Improve response when no match is found
    }

    private function matchRequest(Expectation $expectation): bool
    {
        $expectationPath = $this->serverData['REQUEST_URI'];
        $pathCondition = $expectation->getRequest()->getPath();
        if (!$this->pathMatcherChain->matches($expectationPath, $pathCondition)) {
            return false;
        }

        $expectationMethod = $this->serverData['REQUEST_METHOD'];
        $methodCondition = $expectation->getRequest()->getMethod();
        if (!$this->methodMatcherChain->matches($expectationMethod, $methodCondition)) {
            return false;
        }

        $expectationBody = $expectation->getRequest()->getBody();
        $bodyCondition = $this->inputData;
        if ($expectationBody && !$this->bodyMatcherChain->matches($expectationBody, $bodyCondition)) {
            return false;
        }


        $expectationHeaders = $expectation->getRequest()->getHeaders();
        $serverData = $this->serverData;
        if ($expectationHeaders && !$this->headerMatcherChain->matches($expectationHeaders, $serverData)) {
            return false;
        }

        return true;
    }

    private function buildResponse($response)
    {
        // FIXME: Move response builder to its own class
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


    public function dispatch()
    {
        $expectations = $this->assertionRepository->fetchAll();
        foreach($expectations as $expectation) {
            if($this->match($expectation)) {
                return true;
            }
        }

        throw new MatchNotFoundException('No match was found for this request!');
    }
}
