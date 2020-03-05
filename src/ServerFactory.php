<?php

namespace Mabrahao\MockServer;

class ServerFactory
{
    public static function newInstance(string $host, int $port, int $sleepTime, string $storageType): MockServer
    {
        return new MockServer($host, $port, $sleepTime, $storageType);
    }
}
