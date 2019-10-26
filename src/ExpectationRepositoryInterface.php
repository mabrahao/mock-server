<?php

namespace mabrahao\MockServer;

interface ExpectationRepositoryInterface
{
    /**
     * @param Expectation $expectation
     * @return bool
     */
    public function store(Expectation $expectation): bool;

    /**
     * @return Expectation[]
     */
    public function fetchAll(): array;

    /**
     * @return bool
     */
    public function nukeAllExpectations(): bool;
}
