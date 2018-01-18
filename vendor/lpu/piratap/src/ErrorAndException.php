<?php
namespace LPU;

class ErrorAndException
{
    /**
     * Display the error message.
     */
    public static function displayErrorMessage()
    {
        Application::end();

        echo 'error';
    }

    /**
     * Display the exception message.
     */
    public static function displayExceptionMessage()
    {
        Application::end();

        echo 'exception';
    }
}
