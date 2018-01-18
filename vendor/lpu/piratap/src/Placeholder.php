<?php
namespace LPU;

class Placeholder
{
    private static $placeholder = [
        'long'  => '',
        'short' => '',
    ];

    /**
     * Set up the placeholder configuration.
     */
    public static function setup()
    {
        self::$placeholder['long'] = ' - ';
        self::$placeholder['short'] = 'N/A';
    }

    /**
     * Display the placeholder
     *
     * @param string $type
     */
    public static function display($type)
    {
        echo self::$placeholder[$type];
    }

    /**
     * Get the placeholder
     *
     * @param string $type
     *
     * @return string
     */
    public static function get($type)
    {
        return self::$placeholder[$type];
    }
}
