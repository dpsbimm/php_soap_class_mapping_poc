<?php

namespace AppBundle\Entity;

class BusinessObject
{
    /**
     * @var string
     */
    public $firstValue;

    /**
     * @var string
     */
    public $secondValue;

    /**
     * @return string
     */
    public function getFirstValue()
    {
        return $this->firstValue;
    }

    /**
     * @param string $firstValue
     */
    public function setFirstValue($firstValue)
    {
        $this->firstValue = $firstValue;
    }

    /**
     * @return string
     */
    public function getSecondValue()
    {
        return $this->secondValue;
    }

    /**
     * @param string $secondValue
     */
    public function setSecondValue($secondValue)
    {
        $this->secondValue = $secondValue;
    }
}
