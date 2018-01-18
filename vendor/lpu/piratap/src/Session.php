<?php
namespace LPU;

class Session
{
    /**
     * Set up the session configuration.
     */
    private static function setup()
    {
        session_set_cookie_params(Config::get('session')['lifetime'], '/');
    }

    /**
     * Start the session.
     *
     * This is required when the application needs to process session variables.
     */
    public static function start()
    {
        self::setup();

        session_start();
    }

    /**
     * Clear a session.
     *
     * @param string $name
     */
    public static function clear($name)
    {
        unset($_SESSION[Config::get('session')['name']][$name]);
    }

    /**
     * Create a session.
     *
     * This would require the application to have a session already started
     * using the Session::start() method.
     *
     * @param string $name
     * @param object $value
     */
    public static function create($name, $value)
    {
        $_SESSION[Config::get('session')['name']][$name] = $value;
    }

    /**
     * Get a session data.
     *
     * @param string $name
     *
     * @return object
     */
    public static function get($name)
    {
        if (empty($_SESSION[Config::get('session')['name']][$name])) {
            return false;
        }

        return $_SESSION[Config::get('session')['name']][$name];
    }

    /**
     * Destroy the current session.
     */
    public static function destroy()
    {
        session_destroy();
    }
}
