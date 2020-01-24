<?php

namespace mabrahao\MockServer\Model;

class Times
{
    /** @var int */
    private $expectedAmount;
    /** @var int */
    private $actualAmount;
    /** @var bool */
    private $any;

    /**
     * Times constructor.
     * @param $expectedAmount
     * @param bool $any
     * @param int $actualAmount
     */
    private function __construct($expectedAmount, $any = false, int $actualAmount = 0)
    {
        $this->expectedAmount = $expectedAmount;
        $this->actualAmount = $actualAmount;
        $this->any = $any;
    }

    public function getRemaining(): int
    {
        return $this->expectedAmount - $this->actualAmount;
    }

    public function incrementActual(): self
    {
        $this->actualAmount++;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'expectedAmount' => $this->expectedAmount,
            'any' => $this->any,
            'actualAmount' => $this->expectedAmount,
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
          $times['expectedAmount'],
          $times['any'],
          $times['actualAmount']
        );
    }
}