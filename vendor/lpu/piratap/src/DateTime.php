<?php
namespace LPU;

class DateTime
{
    /**
     * Get the date and time.
     *
     * @param string $format
     * @param datetime $datetime
     *
     * @return datetime
     */
    public static function get($format, $datetime = null)
    {
        try {
            return (new \DateTime($datetime))->format($format);
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * Convert the date and time format.
     *
     * @param string $format
     * @param datetime $datetime
     *
     * @return datetime
     */
    public static function convert($format, $datetime)
    {
        if (!$datetime) {
            return null;
        }

        return self::get($format, $datetime);
    }

    /**
     * Display the date and time.
     *
     * @param string $format
     */
    public static function display($format)
    {
        echo self::get($format);
    }
}
