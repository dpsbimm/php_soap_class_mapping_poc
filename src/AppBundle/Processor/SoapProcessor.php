<?php

namespace AppBundle\Processor;

use AppBundle\Entity\BusinessObject;

class SoapProcessor
{
    /**
     * Get a BusinessObject
     *
     * @return \AppBundle\Entity\BusinessObject
     */
    public function getBusinessObject()
    {
        $businessObject = new BusinessObject();

        $businessObject->setFirstValue('my first value');
        $businessObject->setSecondValue('my second value');

        return $businessObject;
    }

    /**
     * Get first value from BusinessObject
     *
     * @param \AppBundle\Entity\BusinessObject $businessObject
     * @return string
     */
    public function getFirstValueFromBusinessObject(BusinessObject $businessObject)
    {
        return $businessObject->getFirstValue();
    }
}
