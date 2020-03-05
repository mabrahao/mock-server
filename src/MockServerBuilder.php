<?php

namespace Mabrahao\MockServer;

use Mabrahao\MockServer\Enum\Storage;
use Mabrahao\MockServer\ExpectationRepository\ExpectationRepositoryFactory;

class MockServerBuilder
{
    public static function build(string $host = '127.0.0.1', int $port = 0, $sleepTime = 200000, $storageType = Storage::TEMP_FILE): MockServerClient
    {
        return new MockServerClient(
            ServerFactory::newInstance($host, $port, $sleepTime, $storageType),
            ExpectationRepositoryFactory::newInstance($storageType)
        );
    }
}
