<?php


namespace WirecardClient\Responses;


final class RegisterPayment extends Base
{

    /**
     * @return mixed
     */
    public function getPaymentRedirectUrl() {
        return $this->{'payment-redirect-url'};
    }
}