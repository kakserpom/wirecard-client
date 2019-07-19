<?php


namespace WirecardClient\Responses;


abstract class Base
{
    /**
     * Base constructor.
     * @param \stdClass $object
     */
    public function __construct(\stdClass $object)
    {
        foreach ($object as $prop => $value) {
            $this->{$prop} = $value;
        }
    }
}
