<?php
namespace LPU;

class Authentication
{
    /**
     * Get the current authenticated user.
     *
     * @return int
     */
    public static function getAuthenticatedUser()
    {
        return Session::get('authenticated_user');
    }

    /**
     * Validate if the current user has authentication to the route.
     *
     * @param string $route
     *
     * @return bool
     */
    public static function authenticateUser($route)
    {
        if (!Route::get()[$route]['data']['no_auth'] && !Route::get()[$route]['data']['auth']) {
            return true;
        }

        return self::getAuthenticatedUser();
    }
}
