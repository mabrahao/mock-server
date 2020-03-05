<?php

namespace Mabrahao\MockServer;

use Mabrahao\MockServer\ExpectationRepository\ExpectationRepositoryFactory;
use Mabrahao\MockServer\Matchers\Body\BodyMatcher;
use Mabrahao\MockServer\Matchers\Header\HeaderMatcher;
use Mabrahao\MockServer\Matchers\Method\MethodMatcher;
use Mabrahao\MockServer\Matchers\Path\PathMatcher;
use Mabrahao\MockServer\Matchers\RequestMatcher;

class RequestHandlerBuilder
{
    public static function build(string $storageType, array $serverData, array $formData, $inputData) {
        $requestMatcher = new RequestMatcher(
            new PathMatcher(),
            new MethodMatcher(),
            new BodyMatcher(),
            new HeaderMatcher()
        );

        $responseBuilder = new ResponseBuilder();

        $assertionRepository = ExpectationRepositoryFactory::newInstance($storageType);

        return new RequestHandler($requestMatcher, $responseBuilder, $assertionRepository, $serverData, $formData, $inputData);
    }
}
