<?php


namespace WirecardClient\Types;


abstract class Base
{
    /**
     * @param object $object
     * @return static
     */
    public static function fromObject(object $object)
    {
        $class = static::class;
        $str = serialize($object);
        $split = explode(':', $str, 4);
        $split[1] = strlen($class);
        $split[2] = rtrim(explode(':', serialize($class), 3)[2], ';');
        $str = join(':', $split);
        return unserialize($str);
    }

    /**
     * @param string $str
     * @return mixed
     */
    private function camelcase(string $str)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $str))));
    }

    /**
     * @param string $str
     * @return mixed
     */
    private function uncamelcase(string $str)
    {
        return trim(preg_replace_callback('~(?<![A-Z])[A-Z]~', function (array $match) {
            return '-' . strtolower($match[0]);
        }, $str), '-');
    }

    /**
     * @param string $method
     * @param array $args
     */
    public function __call(string $method, array $args)
    {
        $prefix = substr($method, 0, 3);
        $name = substr($method, 3);
        if ($prefix === 'get') {
            return $this->{self::uncamelcase($name)};
        } elseif ($prefix === 'set') {
            $key = self::uncamelcase($name);
            if (!isset($args[0]) || $args[0] === null) {
                unset($this->{$key});
            } else {
                $this->{$key} = $args[0];
            }
            return $this;
        } else {
            throw new \ErrorException('Undefined method called: ' . $method);
        }
    }
}
