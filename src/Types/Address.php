<?php


namespace WirecardClient\Types;


final class Address extends Base
{
    /**
     * @param string $street1
     * @param string $city
     * @param string $state
     * @param string $country
     * @param string $postalCode
     * @return Address
     */
    public static function make(string $street1, string $city, string $state, string $country, string $postalCode)
    {
        $self = new self;
        $self->street1 = $street1;
        $self->city = $city;
        $self->state = $state;
        $self->country = $country;
        $self->{'postal-code'} = $postalCode;
        return $self;
    }
}