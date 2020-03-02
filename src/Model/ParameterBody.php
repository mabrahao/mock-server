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
        $this->params = $this->sortParams($params);
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

    /**
     * @param array $params
     * @return Param[]
     */
    private function sortParams(array $params)
    {
        usort($params, function (Param $a, Param $b) {
            return strcmp($a->getKey(), $b->getKey());
        });

        return $params;
    }
}
