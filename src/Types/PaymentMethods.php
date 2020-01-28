<?php


namespace WirecardClient\Types;


final class PaymentMethods extends Base
{
    /**
     * @var array
     */
    private $methods = [];

    /**
     * @param array $methods
     */
    public function __construct(array $methods)
    {
        $this->methods = $methods;
        $array = [];
        foreach ($methods as $name) {
            $array[] = ['name' => $name];
        }
        $this->{'payment-method'} = $array;
    }

    /**
     * @param string $method
     * @return bool
     */
    public function hasMethod(string $method): bool
    {
        return in_array($method, $this->methods, true);
    }
}