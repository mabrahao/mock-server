<?php

namespace Mabrahao\MockServer\Model;

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

    public static function never(): self
    {
        return new self(0, false);
    }

    public function incrementActual(): self
    {
        $this->actualAmount++;
        return $this;
    }

    public function isAny()
    {
        return $this->any;
    }

    public function matchesExpectation()
    {
        if ($this->isAny()) {
            return true;
        }

        if ($this->getActualAmount() === $this->getExpectedAmount()) {
            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function getExpectedAmount(): int
    {
        return $this->expectedAmount;
    }

    /**
     * @return int
     */
    public function getActualAmount(): int
    {
        return $this->actualAmount;
    }


    public function toArray(): array
    {
        return [
            'expectedAmount' => $this->getExpectedAmount(),
            'any' => $this->isAny(),
            'actualAmount' => $this->getActualAmount(),
        ];
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