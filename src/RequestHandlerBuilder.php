<?php

namespace mabrahao\MockServer;

use mabrahao\MockServer\Matchers\Body\BodyMatcher;
use mabrahao\MockServer\Matchers\Header\HeaderMatcher;
use mabrahao\MockServer\Matchers\Method\MethodMatcher;
use mabrahao\MockServer\Matchers\Path\PathMatcher;
use mabrahao\MockServer\Matchers\RequestMatcher;

class RequestHandlerBuilder
{
    public static function build(string $storageType, array $serverData, $inputData) {
        $requestMatcher = new RequestMatcher(
            new PathMatcher(),
            new MethodMatcher(),
            new BodyMatcher(),
            new HeaderMatcher()
        );

        $responseBuilder = new ResponseBuilder();

        $assertionRepository = ExpectationRepositoryFactory::newInstance($storageType);

        return new RequestHandler($requestMatcher, $responseBuilder, $assertionRepository, $serverData, $inputData);
    }
}
