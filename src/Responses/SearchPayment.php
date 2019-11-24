<?php


namespace WirecardClient\Responses;


use WirecardClient\Exceptions\DataNotFoundException;
use WirecardClient\Types\Payment;

final class SearchPayment extends Base
{
    /**
     *
     */
    public function getPayment()
    {
        if (!(array)$this->payment) {
            throw new DataNotFoundException;
        }
        return Payment::fromObject($this->payment);
    }
}