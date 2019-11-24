<?php


namespace WirecardClient\Types;


final class ThreeD extends Base
{
    /**
     * @param bool $attemptThreeD
     * @return ThreeD
     */
    public function __construct(bool $attemptThreeD)
    {
        $this->{'attempt-three-d'} = $attemptThreeD ? 'true' : 'false';
    }
}