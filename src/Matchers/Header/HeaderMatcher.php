<?php

namespace mabrahao\MockServer\Matchers\Header;

class HeaderMatcher implements HeaderMatcherInterface
{
    public function matches(array $expectationHeaders, array $serverData): bool
    {
        foreach($expectationHeaders as $headerKey => $headerValue) {
            $requestHeader = $this->getExpectationHeaderOnRequest($headerKey, $serverData);

            if (!$requestHeader) {
                return false;
            }

            if ($requestHeader !== $headerValue)
            {
                return false;
            }
        }

        return true;
    }

    private function getExpectationHeaderOnRequest(string $headerKey, array $serverData): ?string
    {
        $newKey = 'HTTP_'.strtoupper(str_replace([' ', '-'], '_', $headerKey));
        return $serverData[$newKey] ?? null;
    }
}
