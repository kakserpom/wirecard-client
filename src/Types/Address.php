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
    public function __construct(string $street1, string $city, string $state, string $country, string $postalCode)
    {
        $this->street1 = $street1;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->{'postal-code'} = $postalCode;
    }
}