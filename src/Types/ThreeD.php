<?php


namespace WirecardClient\Types;


final class ThreeD extends Base
{
    /**
     * @param bool $attemptThreeD
     * @return ThreeD
     */
    public static function make(bool $attemptThreeD)
    {
        $self = new self;
        $self->{'attempt-three-d'} = $attemptThreeD ? 'true' : 'false';
        return $self;
    }
}