<?php


namespace WirecardClient\Types;


final class Device extends Base
{
    /**
     * @param string $fingerprint
     * @return Device
     */
    public function __construct(string $fingerprint)
    {
        $this->fingerprint = $fingerprint;
    }
}