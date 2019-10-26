<?php

namespace mabrahao\MockServer\Model;

class Times
{
    private $counter;

    /**
     * Times constructor.
     * @param $counter
     */
    private function __construct($counter)
    {
        $this->counter = $counter;
    }

    public static function any(): self
    {
        return new self(-1);
    }

    public static function once(): self
    {
        return new self(1);
    }

    public static function exactly(int $times): self
    {
        return new self($times);
    }

    public function getRemaining(): int
    {
        return $this->counter;
    }

    public function decrement(): self
    {
        $this->counter--;
        return $this;
    }
}