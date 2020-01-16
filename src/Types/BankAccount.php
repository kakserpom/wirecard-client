<?php


namespace WirecardClient\Types;


final class BankAccount extends Base
{
    /**
     * BankAccount constructor.
     * @param string $iban
     * @param string $bic
     */
    public function __construct(string $iban, string $bic)
    {
        $this->iban = $iban;
        $this->bic = $bic;
    }

    /**
     * @return string
     */
    public function getIban(): string
    {
        return $this->iban;
    }

    /**
     * @return string
     */
    public function getBic(): string
    {
        return $this->bic;
    }
}