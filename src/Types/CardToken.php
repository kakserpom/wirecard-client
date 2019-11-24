<?php


namespace WirecardClient\Types;


final class CardToken extends Base
{
    /**
     * @param string $token
     * @param string $mask
     * @return CardToken
     */
    public function __construct(string $token, string $mask)
    {
        $this->{'token-id'} = $token;
        $this->{'masked-account-number'} = $mask;
    }
}