<?php


namespace WirecardClient\Types;


final class Amount extends Base
{
    /**
     * @param float $amount
     * @param string $currency
     * @return Amount
     */
    public function __construct(float $amount, string $currency)
    {
        $this->value = $amount;
        $this->currency = $currency;
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