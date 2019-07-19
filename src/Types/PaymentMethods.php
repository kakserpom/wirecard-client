<?php


namespace WirecardClient\Types;


final class PaymentMethods extends Base
{
    /**
     * @param array $methods
     */
    public function make(array $methods)
    {
        $self = new self;
        $self->methods = $methods;
        return $self;
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