<?php


namespace WirecardClient\Types;


final class Periodic extends Base
{
    /**
     * @param string $periodicType periodic/recurring
     * @param string $sequenceType first/recurring/final
     * @return Periodic
     */
    public static function make(string $periodicType, string $sequenceType)
    {
        $self = new self;
        $self->setPeriodicType($periodicType);
        $self->setSequenceType($sequenceType);
        return $self;
    }
}