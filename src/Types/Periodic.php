<?php


namespace WirecardClient\Types;


final class Periodic extends Base
{
    /**
     * @param string $periodicType periodic/recurring
     * @param string $sequenceType first/recurring/final
     * @return Periodic
     */
    public function __construct(string $periodicType, string $sequenceType)
    {
        $this->setPeriodicType($periodicType);
        $this->setSequenceType($sequenceType);
    }
}