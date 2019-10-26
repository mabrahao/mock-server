<?php

namespace mabrahao\MockServer\Model;

class Times
{
    private $counter;
    /** @var bool */
    private $any;

    /**
     * Times constructor.
     * @param $counter
     * @param bool $any
     */
    private function __construct($counter, $any = false)
    {
        $this->counter = $counter;
        $this->any = $any;
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

    public function toArray(): array
    {
        return [
            'counter' => $this->counter,
            'any' => $this->any,
        ];
    }

    public function isAny()
    {
        return $this->any;
    }

    public static function any(): self
    {
        return new self(0, true);
    }

    public static function once(): self
    {
        return new self(1);
    }

    public static function exactly(int $times): self
    {
        return new self($times);
    }

    public static function fromArray(array $times): self
    {
        return new self(
          $times['counter'],
          $times['any']
        );
    }
}