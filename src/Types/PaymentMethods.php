<?php


namespace WirecardClient\Types;


final class PaymentMethods extends Base
{
    /**
     * @param array $methods
     */
    public function __construct(array $methods)
    {
        $this->methods = $methods;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $ret = [];
        foreach ($this->methods as $name) {
           $ret[] = ['payment-method' => ['name' => $name]];
        }
        return $ret;
    }
}