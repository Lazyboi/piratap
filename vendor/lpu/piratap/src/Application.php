<?php
namespace LPU;

class Application
{
    /**
     * Set up the application configuration.
     */
    private static function setup()
    {
        ini_set('display_errors', 'On');
        ini_set('display_startup_errors', 'On');
        ini_set('track_errors', 'On');
        ini_set('date.timezone', Config::get('datetime')['timezone']);
    }

    /**
     * Start monitoring the application.
     *
     * This is used for monitoring errors and exceptions within the application,
     *  this records every components of the page such as html and scripts.
     */
    public static function monitor()
    {
        //set_error_handler('ErrorAndException::displayMessage');
        //set_exception_handler('ErrorAndException::displayMessage');

        ob_start();
    }

    /**
     * Start the application.
     */
    public static function start()
    {
        self::setup();
        self::monitor();
    }

    /**
     * Stop the application and clean all recorded components.
     *
     * This is used when an error was encountered during page load, this will
     * clear every recorded components of the page.
     */
    public static function end()
    {
        ob_end_clean();
    }
}
