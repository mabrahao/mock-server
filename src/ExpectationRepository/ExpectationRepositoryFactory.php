<?php

namespace mabrahao\MockServer\ExpectationRepository;

use mabrahao\MockServer\Enum\Storage;

class ExpectationRepositoryFactory
{
    public static function newInstance(string $storageType): ExpectationRepositoryInterface
    {
        switch ($storageType) {
            case Storage::TEMP_FILE:
            default:
                return new TempFileExpectationRepository();
        }
    }
}
