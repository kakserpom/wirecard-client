<?php


namespace WirecardClient\Types;


final class Amount extends Base
{
    /**
     * @param float $amount
     * @param string $currency
     * @return Amount
     */
    public static function make(float $amount, string $currency)
    {
        $self = new self;
        $self->value = $amount;
        $self->currency = $currency;
        return $self;
    }


    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}