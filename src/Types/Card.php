<?php


namespace WirecardClient\Types;


final class Card extends Base
{
    /**
     * @param string $number
     * @param int $expMonth
     * @param int $expYear
     * @param string $type
     * @param string $code
     * @return Card
     */
    public function __construct(string $number, int $expMonth, int $expYear, string $type, string $code)
    {
        $this->{'account-number'} = $number;
        $this->{'expiration-month'} = sprintf('%02d', $expMonth);
        $this->{'expiration-year'} = sprintf('%02d', $expYear);
        $this->{'card-type'} = $type;
        $this->{'card-security-code'} = $code;
    }
}