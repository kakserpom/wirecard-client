<?php

namespace WirecardClient\Types;

final class BankAccount extends Base
{
    /**
     * @var string
     */
    public $iban;

    /**
     * @var ?string
     */
    public $bic;

    /**
     * BankAccount constructor.
     *
     * @param string      $iban
     * @param string|null $bic
     */
    public function __construct (string $iban, ?string $bic = null)
    {
        $this->iban = $this->format($iban);
        if (strlen($bic)) {
            $this->bic = $this->format($bic);
        }
    }

    /**
     * @param string $str
     *
     * @return string
     */
    private function format (string $str): string
    {
        return strtoupper(preg_replace('~\s+~', '', $str));
    }

    /**
     * @return string
     */
    public function getIban (): string
    {
        return $this->iban;
    }

    /**
     * @return string|null
     */
    public function getBic (): ?string
    {
        return $this->bic;
    }

    /**
     * @return bool
     */
    public function hasBic (): bool
    {
        return $this->bic !== null;
    }
}