<?php
namespace LPU;

class Config
{
    private static $config = [];

    /**
     * Set up the configuration.
     */
    public static function setup()
    {
        foreach (glob('../config/*.php') as $config) {
            self::$config = array_merge(self::$config, (include $config));
        }
    }

    /**
     * Get the application configuration.
     *
     * @param string $config
     *
     * @return array
     */
    public function get($config)
    {
        return self::$config[$config];
    }
}
