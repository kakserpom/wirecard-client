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
    public static function make(string $number, int $expMonth, int $expYear, string $type, string $code)
    {
        $self = new self;
        $self->{'account-number'} = $number;
        $self->{'expiration-month'} = sprintf('%02d', $expMonth);
        $self->{'expiration-year'} = sprintf('%02d', $expYear);
        $self->{'card-type'} = $type;
        $self->{'card-security-code'} = $code;
        return $self;
    }
}