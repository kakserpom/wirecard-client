<?php

namespace WirecardClient\Brokers;

use WirecardClient\WirecardClient;
use Zer0\Brokers\Base;
use Zer0\Config\Interfaces\ConfigInterface;

/**
 * Class Client
 * @package WirecardClient\Brokers
 */
final class Client extends Base
{

    /**
     * @param ConfigInterface $config
     * @return WirecardClient
     */
    public function instantiate(ConfigInterface $config): WirecardClient
    {
        return new \WirecardClient\WirecardClient($config->user, $config->password, $config->maid, $config->secret);
    }

    /**
     * @param string $name
     * @param bool $caching
     * @return WirecardClient
     */
    public function get(string $name = '', bool $caching = true): WirecardClient
    {
        return parent::get($name, $caching);
    }
}
