<?php

namespace Mabrahao\MockServer\ExpectationRepository;

use Mabrahao\MockServer\Enum\Storage;

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
