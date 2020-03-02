<?php

namespace mabrahao\MockServer\Model;

class ParameterBody extends Body
{
    /** @var array|Param[] */
    private $params;

    /**
     * ParameterBody constructor.
     * @param Param[] $params
     */
    public function __construct(array $params)
    {
        ksort($params);
        $this->params = $params;
    }

    /**
     * @return array|Param[]
     */
    public function getParams()
    {
        return $this->params;
    }


    public function __toString()
    {
        return $this->getBody();
    }

    public function getBody()
    {
        $body = implode(
            "&",
            array_map(
                function (Param $param) {
                    $key = $param->getKey();
                    $value = strval($param->getValue());
                    return sprintf("%s=%s", $key, $value);
                },
                $this->params
            )
        );

        return $body;
    }
}
