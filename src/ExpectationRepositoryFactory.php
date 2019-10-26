<?php

namespace mabrahao\MockServer;

class ExpectationRepositoryFactory
{
    public static function newInstance(string $storageType): ExpectationRepository
    {
        switch ($storageType) {
            case Storage::TEMP_FILE:
            default:
                return new TempFileExpectationRepository();
        }
    }
}
