<?php


namespace WirecardClient\Types;


final class Device extends Base
{
    /**
     * @param string $fingerprint
     * @return Device
     */
    public static function make(string $fingerprint)
    {
        $self = new self;
        $self->fingerprint = $fingerprint;
        return $self;
    }
}