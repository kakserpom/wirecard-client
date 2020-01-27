<?php


namespace WirecardClient\Types;


final class PaymentMethods extends Base
{
    /**
     * @param array $methods
     */
    public function __construct(array $methods)
    {
        $array = [];
        foreach ($methods as $name) {
            $array[] = ['name' => $name];
        }
        $this->{'payment-method'} = $array;
    }
}