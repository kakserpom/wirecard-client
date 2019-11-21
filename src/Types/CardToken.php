<?php


namespace WirecardClient\Types;


final class CardToken extends Base
{
    /**
     * @param string $token
     * @param string $mask
     * @return CardToken
     */
    public static function make(string $token, string $mask)
    {
        $self = new self;
        $self->{'token-id'} = $token;
        $self->{'masked-account-number'} = $mask;
        return $self;
    }
}