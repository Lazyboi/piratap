<?php
namespace LPU;

class Permission
{
    private static $permissions = [];


    public static function isAdmin()
    {
        $admin = false;
        $user = Database::table('umg_users_roles a')
            ->innerJoin([
                'umg_roles b' => [
                'a.role_id = b.id'],
            ])
            ->where([
                ['a.user_id', '=', Authentication::getAuthenticatedUser()],
            ])
            ->select([
                'a.user_id',
            ])
            ->fetch();

            if ($user['user_id'] == 1){
                $admin = true;
            }
        return $admin;
    }

    public static function getUserId()
    {
        if (!Authentication::getAuthenticatedUser()) {
            return false;
        } else {
            return Authentication::getAuthenticatedUser();
        }
    }

    /**
     * Load all permissions of the current authenticated user.
     */
    public static function load()
    {
        if (!Authentication::getAuthenticatedUser()) {
            return;
        }

        self::$permissions = Database::table('umg_users_roles a')
            ->innerJoin([
                'umg_roles b'             => [
                    'a.role_id = b.id'
                ],
                'umg_roles_permissions c' => [
                    'b.id = c.role_id'
                ],
                'umg_permissions d'       => [
                    'c.permission_id = d.id'
                ],
                'umg_users e'             => [
                    'a.user_id = e.id'
                ],
            ])
            ->where([
                ['a.user_id', '=', Authentication::getAuthenticatedUser()],
                ['b.disabled_at', 'IS NULL'],
                ['b.disabled_by', 'IS NULL'],
                ['b.deleted_at', 'IS NULL'],
                ['b.deleted_by', 'IS NULL'],
                ['d.disabled_at', 'IS NULL'],
                ['d.disabled_by', 'IS NULL'],
                ['e.disabled_at', 'IS NULL'],
                ['e.disabled_by', 'IS NULL'],
                ['e.deleted_at', 'IS NULL'],
                ['e.deleted_by', 'IS NULL'],
            ])
            ->select([
                'd.slug',
            ])
            ->fetchAll();
    }

    /**
     * Validate if the current user has permission to the route.
     *
     * @param string $route
     *
     * @return bool
     */
    public static function can($route)
    {
        if (!Route::get()[$route]['data']['permission']) {
            return true;
        }

        if (empty(self::$permissions)) {
            return false;
        }

        return in_array($route, array_column(self::$permissions, 'slug'));
    }
}
