<?php

namespace mabrahao\MockServer\Model;

class Param
{
    /** @var string */
    private $key;
    private $value;

    /**
     * Param constructor.
     * @param string $key
     * @param $value
     */
    private function __construct(string $key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public static function new(string $key, $value)
    {
        return new self($key, $value);
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
