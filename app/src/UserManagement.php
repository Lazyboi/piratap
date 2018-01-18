<?php
namespace App;

use LPU\Authentication;
use LPU\Database;
use LPU\Datalist;
use LPU\DateTime;
use LPU\Form;
use LPU\Path;
use LPU\Permission;
use LPU\Placeholder;
use LPU\Route;
use LPU\Security;
use LPU\Url;

class UserManagement
{
    private static $account_data = [];
    private static $permission_data = [];
    private static $role_data = [];
    private static $department_data = [];
    private static $user_data = [];

    /**
     * Display the activity of the current authenticated user.
     */
    public static function displayUserActivity()
    {
        $activity = '';

        foreach (Security::getUserActivty(Authentication::getAuthenticatedUser()) as $user_activity) {
            $activity .= '<div class=\'post\'>';
            $activity .= '<div class=\'user-block\'>';

            if (file_exists(Path::getUserImage(Authentication::getAuthenticatedUser()))) {
                $activity .= '<img alt=\'User Image\' class=\'img-circle img-bordered-sm\' src=\'' . Url::getUserImage(Authentication::getAuthenticatedUser()) . '\'>';
            } else {
                $activity .= '<img alt=\'User Image\' class=\'img-circle img-bordered-sm\' src=\'' . Url::getUserImage('default') . '\'>';
            }

            $activity .= '<span class=\'username\'>';
            $activity .= "<a>{$user_activity['name']}</a>";
            $activity .= '</span>';
            $activity .= "<span class='description'>{$user_activity['created_at']}</span>";
            $activity .= '</div>';
            $activity .= "<p>{$user_activity['details']}</p>";
            $activity .= '</div>';
        }

        echo $activity ? $activity : Placeholder::get('long') ;
    }

    /**
     * Load the profile data of the current authenticated user.
     */
    public static function loadUserProfileData()
    {
        self::$account_data = Database::table('umg_users a')
            ->leftJoin([
                'umg_genders b' => [
                    'a.gender_id = b.id'
                ],
            ])
            ->where([
                ['a.id', '=', Authentication::getAuthenticatedUser()],
            ])
            ->select([
                'a.id',
                'a.username',
                'a.first_name',
                'a.middle_name',
                'a.last_name',
                Database::dateFormat('a.birthdate', '\'%M %d, %Y\'', 'birthdate'),
                'a.gender_id',
                Database::plain(0)
                    ->table('umg_users_email_addresses', 0)
                    ->where([
                        ['umg_users_email_addresses.user_id', '=', 'a.id'],
                    ], 0)
                    ->select([
                        Database::groupConcat([
                            'umg_users_email_addresses.email_address',
                        ], "' '"),
                    ], 0, 'email_addresses'),
                Database::concat([
                    'a.first_name',
                    "' '",
                    'a.last_name',
                ], 'name'),
                Database::dateFormat('a.birthdate', '\'%M %d, %Y\'', 'birthdate'),
                'b.name AS gender',
                Database::dateFormat('a.created_at', '\'%M %d, %Y %l:%i:%s %p\'', 'created_at'),
                Database::dateFormat('a.updated_at', '\'%M %d, %Y %l:%i:%s %p\'', 'updated_at'),
                Database::plain(0)
                    ->table('umg_users_email_addresses', 0)
                    ->where([
                        ['umg_users_email_addresses.user_id', '=', 'a.id'],
                    ], 0)
                    ->select([
                        Database::groupConcat([
                            'umg_users_email_addresses.email_address',
                        ], "' '"),
                    ], 0, 'email_addresses'),
                Database::plain(0)
                    ->table('umg_users_departments', 0)
                    ->leftJoin([
                        'umg_departments' => [
                            'umg_users_departments.department_id = umg_departments.id'
                        ],
                    ], 0)
                    ->where([
                        ['umg_users_departments.user_id', '=', 'a.id'],
                        ['umg_departments.deleted_at', 'IS NULL'],
                        ['umg_departments.deleted_by', 'IS NULL'],
                    ], 0)
                    ->select([
                        Database::groupConcat([
                            Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', "' '", "' text-disabled'"),
                            'umg_departments.name',
                            "'</span>'",
                        ], "' '"),
                    ], 0, 'departments'),
                Database::plain(0)
                    ->table('umg_users_roles', 0)
                    ->leftJoin([
                        'umg_roles' => [
                            'umg_users_roles.role_id = umg_roles.id'
                        ],
                    ], 0)
                    ->where([
                        ['umg_users_roles.user_id', '=', 'a.id'],
                        ['umg_roles.deleted_at', 'IS NULL'],
                        ['umg_roles.deleted_by', 'IS NULL'],
                    ], 0)
                    ->select([
                        Database::groupConcat([
                            Database::condition('umg_roles.disabled_at IS NULL AND umg_roles.disabled_by IS NULL', "' '", "' text-disabled'"),
                            'umg_roles.name',
                        ], "' '"),
                    ], 0, 'roles'),
            ])
            ->fetch();
    }

    /**
     * Display the profile data of the current authenticated user.
     *
     * @param string $data
     */
    public static function displayUserProfileData($data)
    {
        echo self::$account_data[$data] ? self::$account_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    /**
     * Get the profile data of the current authenticated user.
     */
    public static function getUserProfileFieldData()
    {
        $data = Database::table('umg_users')
            ->where([
                ['id', '=', Authentication::getAuthenticatedUser()],
            ])
            ->select()
            ->fetch();

        if ($data) {
            Form::createFieldData('first_name', $data['first_name']);
            Form::createFieldData('middle_name', $data['middle_name']);
            Form::createFieldData('last_name', $data['last_name']);
            Form::createFieldData('birthdate', DateTime::convert('F d, Y', $data['birthdate']));
            Form::createFieldData('gender', $data['gender_id']);
        }

        $data = Database::table('umg_users_email_addresses')
            ->where([
                ['user_id', '=', Authentication::getAuthenticatedUser()],
            ])
            ->select([
                'email_address',
            ])
            ->fetchAll();

        if ($data) {
            Form::createFieldData('email_addresses', implode(',', array_column($data, 'email_address')));
        }
    }

    /**
     * Edit the profile of the current authenticated user.
     */
    public static function editProfile()
    {
        Database::beginTransaction();

        $data = Database::table('umg_users')
            ->where([
                ['id', '=', Authentication::getAuthenticatedUser()],
            ])
            ->select()
            ->fetch();

        if (!Security::verifyPassword(Form::getFieldData('password'), $data['password'])) {
            Form::setState('Cannot edit the profile. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('password', 'Incorrect password.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_users')
            ->set([
                ['first_name', Form::getFieldData('first_name')],
                ['middle_name', Form::getFieldData('middle_name')],
                ['last_name', Form::getFieldData('last_name')],
                ['birthdate', DateTime::convert('Y-m-d', Form::getFieldData('birthdate'))],
                ['gender_id', Form::getFieldData('gender')],
            ])
            ->where([
                ['id', '=', Authentication::getAuthenticatedUser()],
            ])
            ->update()) {
            Form::setState('Cannot edit the profile. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_users_email_addresses')
            ->where([
                ['user_id', '=', Authentication::getAuthenticatedUser()],
            ])
            ->purge()) {
            Form::setState('Cannot edit the profile. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        if (Form::getFieldData('email_addresses')) {
            foreach (explode(',', Form::getFieldData('email_addresses')) as $email_address) {
                if (!Database::table('umg_users_email_addresses')
                    ->values([
                        ['email_address', $email_address],
                        ['user_id', Authentication::getAuthenticatedUser()],
                    ])
                    ->insert()) {
                    Form::setState('Cannot edit the profile. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (!Database::commit()) {
            Form::setState('Cannot edit the profile. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Profile has been successfully edited', 'Your profile will now be updated in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Change the password of the current authenticated user.
     */
    public static function changePassword()
    {
        $data = Database::table('umg_users')
            ->where([
                ['id', '=', Authentication::getAuthenticatedUser()],
            ])
            ->select()
            ->fetch();

        if (!Security::verifyPassword(Form::getFieldData('current_password'), $data['password'])) {
            Form::setState('Cannot change the password. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('current_password', 'Incorrect password.', Form::VALIDATION_ERROR);
            return;
        }

        if (Form::getFieldData('new_password') != Form::getFieldData('confirm_new_password')) {
            Form::setState('Cannot change the password. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('confirm_new_password', 'Password does not match.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_users')
            ->set([
                ['password', Security::encryptPassword(Form::getFieldData('new_password'))],
            ])
            ->where([
                ['id', '=', Authentication::getAuthenticatedUser()],
            ])
            ->update()) {
            Form::setState('Cannot change the password. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Password has been successfully changed', 'You can now sign in using the new password.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Display the list of permissions as select box.
     *
     * @param string || array $default_data
     */
    public static function displayPermissionSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('umg_permissions')
            ->orderBy('id', 'DESC')
            ->select([
                'id',
                'name',
                'disabled_at',
                'disabled_by',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of permissions as table.
     */
    public static function displayPermissionTable()
    {
        switch (Route::currentData()) {
            case 'enabled':
                Datalist::displayTable([
                    'id'   => 'ID',
                    'name' => 'NAME',
                    'slug' => 'SLUG',
                ], Database::table('umg_permissions a')
                    ->where([
                        ['a.disabled_at', 'IS NULL'],
                        ['a.disabled_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.slug',
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('view-permission')) {
                            $action .= "<form>
                                          <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-permission', $id) . "' title='" . Route::getName('view-permission')  . "'>" . Route::getIcon('view-permission')  . "</a>
                                        </form>";
                        }

                        if (Permission::can('disable-permission')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='disable_permission' title='" . Route::getName('disable-permission')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-permission')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'disabled':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'slug'        => 'SLUG',
                    'disabled_by' => 'DISABLED BY',
                ], Database::table('umg_permissions a')
                    ->where([
                        ['a.disabled_at', 'IS NOT NULL'],
                        ['a.disabled_by', 'IS NOT NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.slug',
                        Database::getDisabler('a.disabled_at', 'a.disabled_by', 'disabled_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('enable-permission')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs enable-permission-button' name='enable_permission' title='" . Route::getName('enable-permission')  . "' type='submit' value={$id}>" . Route::getIcon('enable-permission')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            default:
        }
    }

    /**
     * Validate the permission.
     */
    public static function validatePermission()
    {
        if (!Database::table('umg_permissions')
            ->where([
                ['id', '=', Route::currentData()],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
            ])
            ->select()
            ->fetch()) {
            Route::go(Route::getParent(Route::current()));
        }
    }

    /**
     * Load the permission data.
     */
    public static function loadPermissionData()
    {
        self::$permission_data = Database::table('umg_permissions')
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->select([
                'id',
                'name',
                'slug',
            ])
            ->fetch();
    }

    /**
     * Display the permission data.
     *
     * @param string $data
     */
    public static function displayPermissionData($data)
    {
        echo self::$permission_data[$data] ? self::$permission_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    /**
     * Disable the permission.
     */
    public static function disablePermission()
    {
        if (!Permission::can('disable-permission')) {
            Form::setState('Cannot disable the the permission. Please try again later', 'You are not authorized to disable the permission.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_permissions')
            ->where([
                ['id', '=', Form::getFieldData('disable_permission')],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
            ])
            ->disable()) {
            Form::setState('Cannot disable the the permission. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Permission has been successfully disabled', 'The permission will no longer be available but will still appear in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Enable the permission.
     */
    public static function enablePermission()
    {
        if (!Permission::can('enable-permission')) {
            Form::setState('Cannot enable the permission. Please try again later', 'You are not authorized to enable the permission.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_permissions')
            ->where([
                ['id', '=', Form::getFieldData('enable_permission')],
                ['disabled_at', 'IS NOT NULL'],
                ['disabled_by', 'IS NOT NULL'],
            ])
            ->enable()) {
            Form::setState('Cannot enable the permission. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Permission has been successfully enabled', 'The permission will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Display the list of roles as select box.
     *
     * @param string || array $default_data
     */
    public static function displayRoleSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('umg_roles')
            ->where([
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->select([
                'id',
                'name',
                'disabled_at',
                'disabled_by',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of roles as table.
     */
    public static function displayRoleTable()
    {
        switch (Route::currentData()) {
            case 'created':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                    'permissions' => 'PERMISSION(S)',
                ], Database::table('umg_roles a')
                    ->where([
                        ['a.disabled_at', 'IS NULL'],
                        ['a.disabled_by', 'IS NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                        Database::plain(0)
                            ->table('umg_roles_permissions', 0)
                            ->leftJoin([
                                'umg_permissions' => [
                                    'umg_roles_permissions.permission_id = umg_permissions.id'
                                ],
                            ], 0)
                            ->where([
                                ['umg_roles_permissions.role_id', '=', 'a.id'],
                            ], 0)
                            ->select([
                                Database::groupConcat([
                                    Database::condition('umg_permissions.disabled_at IS NULL AND umg_permissions.disabled_by IS NULL', "' '", "' text-disabled'"),
                                    'umg_permissions.name',
                                ], "' <br> '"),
                            ], 0, 'permissions'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('view-role')) {
                            $action .= "<form>
                                          <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-role', $id) . "' title='" . Route::getName('view-role')  . "'>" . Route::getIcon('view-role')  . "</a>
                                        </form>";
                        }

                        if (Permission::can('edit-role')) {
                            $action .= "<form method='POST'>
                                          <a class='btn btn-success btn-xs' href='" . Route::getURL('edit-role', $id) . "' title='" . Route::getName('edit-role')  . "'>" . Route::getIcon('edit-role')  . "</a>
                                        </form>";
                        }

                        if (Permission::can('disable-role')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='disable_role' title='" . Route::getName('disable-role')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-role')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('delete-role')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-danger btn-xs' name='delete_role' title='" . Route::getName('delete-role')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-role')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'disabled':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                    'permissions' => 'PERMISSION(S)',
                    'disabled_by' => 'DISABLED BY',
                ], Database::table('umg_roles a')
                    ->where([
                        ['a.disabled_at', 'IS NOT NULL'],
                        ['a.disabled_by', 'IS NOT NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                        Database::plain(0)
                            ->table('umg_roles_permissions', 0)
                            ->leftJoin([
                                'umg_permissions' => [
                                    'umg_roles_permissions.permission_id = umg_permissions.id'
                                ],
                            ], 0)
                            ->where([
                                ['umg_roles_permissions.role_id', '=', 'a.id'],
                            ], 0)
                            ->select([
                                Database::groupConcat([
                                    Database::condition('umg_permissions.disabled_at IS NULL AND umg_permissions.disabled_by IS NULL', "' '", "' text-disabled'"),
                                    'umg_permissions.name',
                                ], "' '"),
                            ], 0, 'permissions'),
                        Database::getDisabler('a.disabled_at', 'a.disabled_by', 'disabled_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('enable-role')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='enable_role' title='" . Route::getName('enable-role')  . "' type='submit' value='{$id}'>" . Route::getIcon('enable-role')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('delete-role')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='delete_role' title='" . Route::getName('delete-role')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-role')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'deleted':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'description' => 'DESCRIPTION',
                    'permissions' => 'PERMISSION(S)',
                    'deleted_by'  => 'DELETED BY',
                ], Database::table('umg_roles a')
                    ->where([
                        ['a.deleted_at', 'IS NOT NULL'],
                        ['a.deleted_by', 'IS NOT NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.description',
                        Database::plain(0)
                            ->table('umg_roles_permissions', 0)
                            ->leftJoin([
                                'umg_permissions' => [
                                    'umg_roles_permissions.permission_id = umg_permissions.id'
                                ],
                            ], 0)
                            ->where([
                                ['umg_roles_permissions.role_id', '=', 'a.id'],
                            ], 0)
                            ->select([
                                Database::groupConcat([
                                    Database::condition('umg_permissions.disabled_at IS NULL AND umg_permissions.disabled_by IS NULL', "' '", "' text-disabled'"),
                                    'umg_permissions.name',
                                ], "' '"),
                            ], 0, 'permissions'),
                        Database::getDeleter('a.deleted_at', 'a.deleted_by', 'deleted_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('restore-role')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='restore_role' title='" . Route::getName('restore-role')  . "' type='submit' value='{$id}'>" . Route::getIcon('restore-role')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('purge-role')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='purge_role' title='" . Route::getName('purge-role')  . "' type='submit' value='{$id}'>" . Route::getIcon('purge-role')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            default:
        }
    }

    /**
     * Validate the role.
     */
    public static function validateRole()
    {
        if (!Database::table('umg_roles')
            ->where([
                ['id', '=', Route::currentData()],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->select()
            ->fetch()) {
            Route::go(Route::getParent(Route::current()));
        }
    }

    /**
     * Load the role data.
     */
    public static function loadRoleData()
    {
        self::$role_data = Database::table('umg_roles a')
            ->where([
                ['a.id', '=', Route::currentData()],
            ])
            ->select([
                'a.id',
                'a.name',
                'a.description',
                Database::plain(0)
                    ->table('umg_roles_permissions', 0)
                    ->leftJoin([
                        'umg_permissions' => [
                            'umg_roles_permissions.permission_id = umg_permissions.id'
                        ],
                    ], 0)
                    ->where([
                        ['umg_roles_permissions.role_id', '=', 'a.id'],
                    ], 0)
                    ->select([
                        Database::groupConcat([
                            Database::condition('umg_permissions.disabled_at IS NULL AND umg_permissions.disabled_by IS NULL', "' '", "' text-disabled'"),
                            'umg_permissions.name',
                        ], "' '"),
                    ], 0, 'permissions'),
                Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
                Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),
            ])
            ->fetch();
    }

    /**
     * Display the role data.
     *
     * @param string $data
     */
    public static function displayRoleData($data)
    {
        echo self::$role_data[$data] ? self::$role_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    /**
     * Load the role field data
     */
    public static function loadRoleFieldData()
    {
        if ($data = Database::table('umg_roles')
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->select()
            ->fetch()) {
            Form::createFieldData('name', $data['name']);
            Form::createFieldData('description', $data['description']);
        }

        if ($data = Database::table('umg_roles_permissions a')
            ->leftJoin([
                'umg_permissions b' => [
                    'a.permission_id = b.id'
                ],
            ])
            ->where([
                ['a.role_id', '=', Route::currentData()],
                ['b.disabled_at', 'IS NULL'],
                ['b.disabled_by', 'IS NULL'],
            ])
            ->select([
                'a.permission_id',
            ])
            ->fetchAll()) {
            Form::createFieldData('permissions', array_column($data, 'permission_id'));
        }
    }

    /**
     * Add a new role.
     */
    public static function addNewRole()
    {
        if (!Permission::can('add-new-role')) {
            Form::setState('Cannot add a new role. Please try again later', 'You are not authorized to add new role.', Form::ALERT_ERROR, true);
            return;
        }

        Database::beginTransaction();

        if (Database::table('umg_roles')
            ->where([
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot add a new role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_roles')
            ->values([
                ['name', Form::getFieldData('name')],
                ['description', Form::getFieldData('description')],
            ])
            ->insert()) {
            Form::setState('Cannot add a new role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        $role_id = Database::lastInsertId();

        if (Form::getFieldData('permissions')) {
            foreach (Form::getFieldData('permissions') as $permission_id) {
                if (!Database::table('umg_roles_permissions')
                    ->values([
                        ['role_id', $role_id],
                        ['permission_id', $permission_id],
                    ])
                    ->insert()) {
                    Form::setState('Cannot add a new role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (!Database::commit()) {
            Form::setState('Cannot add a new role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Role has been successfully added.', 'The role will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Edit the role.
     */
    public static function editRole()
    {
        if (!Permission::can('edit-role')) {
            Form::setState('Cannot edit the role. Please try again later', 'You are not authorized to edit the role.', Form::ALERT_ERROR, true);
            return;
        }

        Database::beginTransaction();

        if (Database::table('umg_roles')
            ->where([
                ['id', '!=', Route::currentData()],
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot edit the role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_roles')
            ->set([
                ['name', Form::getFieldData('name')],
                ['description', Form::getFieldData('description')],
            ])
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->update()) {
            Form::setState('Cannot edit the role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_roles_permissions')
            ->where([
                ['role_id', '=', Route::currentData()],
            ])
            ->purge()) {
            Form::setState('Cannot edit the role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        if (Form::getFieldData('permissions')) {
            foreach (Form::getFieldData('permissions') as $permission_id) {
                if (!Database::table('umg_roles_permissions')
                    ->values([
                        ['role_id', Route::currentData()],
                        ['permission_id', $permission_id],
                    ])
                    ->insert()) {
                    Form::setState('Cannot edit the role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (!Database::commit()) {
            Form::setState('Cannot edit the role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Role has been successfully edited', 'The role will now be updated in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Disable the role.
     */
    public static function disableRole()
    {
        if (!Permission::can('disable-role')) {
            Form::setState('Cannot disable the role. Please try again later', 'You are not authorized to disable the role.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_roles')
            ->where([
                ['id', '=', Form::getFieldData('disable_role')],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->disable()) {
            Form::setState('Cannot disable the role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Role has been successfully disabled', 'The role will no longer be available but will still appear in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Delete the role.
     */
    public static function deleteRole()
    {
        if (!Permission::can('delete-role')) {
            Form::setState('Cannot delete the role. Please try again later', 'You are not authorized to delete the role.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_roles')
            ->where([
                ['id', '=', Form::getFieldData('delete_role')],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->delete()) {
            Form::setState('Cannot delete the role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Role has been successfully deleted', 'The role will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Enable the role.
     */
    public static function enableRole()
    {
        if (!Permission::can('enable-role')) {
            Form::setState('Cannot enable the role. Please try again later', 'You are not authorized to enable the role.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_roles')
            ->where([
                ['id', '=', Form::getFieldData('enable_role')],
                ['disabled_at', 'IS NOT NULL'],
                ['disabled_by', 'IS NOT NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->enable()) {
            Form::setState('Cannot enable the role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Role has been successfully enabled', 'The role will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Restore the role.
     */
    public static function restoreRole()
    {
        if (!Permission::can('restore-role')) {
            Form::setState('Cannot restore the role. Please try again later', 'You are not authorized to restore the role.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_roles')
            ->where([
                ['id', '=', Form::getFieldData('restore_role')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->restore()) {
            Form::setState('Cannot restore the role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Role has been successfully restored', 'The role will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Purge the role.
     */
    public static function purgeRole()
    {
        if (!Permission::can('purge-role')) {
            Form::setState('Cannot purge the role. Please try again later', 'You are not authorized to purge the role.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_roles')
            ->where([
                ['id', '=', Form::getFieldData('purge_role')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->purge()) {
            Form::setState('Cannot purge the role. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Role has been successfully purged', 'The role will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Display the list of departments as select box.
     *
     * @param string || array $default_data
     */
    public static function displayDepartmentSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('umg_departments')
            ->where([
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->select([
                'id',
                'name',
                'disabled_at',
                'disabled_by',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of departments as table.
     */
    public static function displayDepartmentTable()
    {
        switch (Route::currentData()) {
            case 'created':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'acronym'     => 'ACRONYM',
                    'description' => 'DESCRIPTION',
                ], Database::table('umg_departments a')
                    ->where([
                        ['a.disabled_at', 'IS NULL'],
                        ['a.disabled_by', 'IS NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.acronym',
                        'a.description',
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('view-department')) {
                            $action .= "<form>
                                          <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-department', $id) . "' title='" . Route::getName('view-department')  . "'>" . Route::getIcon('view-department')  . "</a>
                                        </form>";
                        }

                        if (Permission::can('edit-department')) {
                            $action .= "<form method='POST'>
                                          <a class='btn btn-success btn-xs' href='" . Route::getURL('edit-department', $id) . "' title='" . Route::getName('edit-department')  . "'>" . Route::getIcon('edit-department')  . "</a>
                                        </form>";
                        }

                        if (Permission::can('disable-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='disable_department' title='" . Route::getName('disable-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-department')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('delete-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-danger btn-xs' name='delete_department' title='" . Route::getName('delete-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-department')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'disabled':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'acronym'     => 'ACRONYM',
                    'description' => 'DESCRIPTION',
                    'disabled_by' => 'DISABLED BY',
                ], Database::table('umg_departments a')
                    ->where([
                        ['a.disabled_at', 'IS NOT NULL'],
                        ['a.disabled_by', 'IS NOT NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.acronym',
                        'a.description',
                        Database::getDisabler('a.disabled_at', 'a.disabled_by', 'disabled_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('enable-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='enable_department' title='" . Route::getName('enable-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('enable-department')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('delete-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='delete_department' title='" . Route::getName('delete-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-department')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'deleted':
                Datalist::displayTable([
                    'id'          => 'ID',
                    'name'        => 'NAME',
                    'acronym'     => 'ACRONYM',
                    'description' => 'DESCRIPTION',
                    'deleted_by'  => 'DELETED BY',
                ], Database::table('umg_departments a')
                    ->where([
                        ['a.deleted_at', 'IS NOT NULL'],
                        ['a.deleted_by', 'IS NOT NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.name',
                        'a.acronym',
                        'a.description',
                        Database::getDeleter('a.deleted_at', 'a.deleted_by', 'deleted_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('restore-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='restore_department' title='" . Route::getName('restore-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('restore-department')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('purge-department')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='purge_department' title='" . Route::getName('purge-department')  . "' type='submit' value='{$id}'>" . Route::getIcon('purge-department')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            default:
        }
    }

    /**
     * Validate the department.
     */
    public static function validateDepartment()
    {
        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Route::currentData()],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->select()
            ->fetch()) {
            Route::go(Route::getParent(Route::current()));
        }
    }

    /**
     * Load the department data.
     */
    public static function loadDepartmentData()
    {
        self::$department_data = Database::table('umg_departments a')
            ->where([
                ['a.id', '=', Route::currentData()],
            ])
            ->select([
                'a.id',
                'a.name',
                'a.acronym',
                'a.description',
                Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
                Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),
            ])
            ->fetch();
    }

    /**
     * Display the department data.
     *
     * @param string $data
     */
    public static function displayDepartmentData($data)
    {
        echo self::$department_data[$data] ? self::$department_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    /**
     * Load the department field data.
     */
    public static function loadDepartmentFieldData()
    {
        if ($data = Database::table('umg_departments')
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->select()
            ->fetch()) {
            Form::createFieldData('name', $data['name']);
            Form::createFieldData('acronym', $data['acronym']);
            Form::createFieldData('description', $data['description']);
        }
    }

    /**
     * Add a new department.
     */
    public static function addNewDepartment()
    {
        if (!Permission::can('add-new-department')) {
            Form::setState('Cannot add a new department. Please try again later', 'You are not authorized to add new department.', Form::ALERT_ERROR, true);
            return;
        }

        if (Database::table('umg_departments')
            ->where([
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot add a new department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (Database::table('umg_departments')
            ->where([
                ['acronym', '=', Form::getFieldData('acronym')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot add a new department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('acronym', 'Acronym has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_departments')
            ->values([
                ['name', Form::getFieldData('name')],
                ['acronym', Form::getFieldData('acronym')],
                ['description', Form::getFieldData('description')],
            ])
            ->insert()) {
            Form::setState('Cannot add a new department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully added.', 'The department will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Edit the department.
     */
    public static function editDepartment()
    {
        if (!Permission::can('edit-department')) {
            Form::setState('Cannot edit the department. Please try again later', 'You are not authorized to edit the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (Database::table('umg_departments')
            ->where([
                ['id', '!=', Route::currentData()],
                ['name', '=', Form::getFieldData('name')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot edit the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('name', 'Name has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (Database::table('umg_departments')
            ->where([
                ['id', '!=', Route::currentData()],
                ['acronym', '=', Form::getFieldData('acronym')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot edit the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('acronym', 'Acronym has already been taken.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_departments')
            ->set([
                ['name', Form::getFieldData('name')],
                ['acronym', Form::getFieldData('description')],
                ['description', Form::getFieldData('description')],
            ])
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->update()) {
            Form::setState('Cannot edit the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully edited', 'The department will now be updated in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Disable the department.
     */
    public static function disableDepartment()
    {
        if (!Permission::can('disable-department')) {
            Form::setState('Cannot disable the department. Please try again later', 'You are not authorized to disable the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Form::getFieldData('disable_department')],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->disable()) {
            Form::setState('Cannot disable the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully disabled', 'The department will no longer be available but will still appear in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Delete the department.
     */
    public static function deleteDepartment()
    {
        if (!Permission::can('delete-department')) {
            Form::setState('Cannot delete the department. Please try again later', 'You are not authorized to delete the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Form::getFieldData('delete_department')],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->delete()) {
            Form::setState('Cannot delete the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully deleted', 'The department will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Enable the department.
     */
    public static function enableDepartment()
    {
        if (!Permission::can('enable-department')) {
            Form::setState('Cannot enable the department. Please try again later', 'You are not authorized to enable the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Form::getFieldData('enable_department')],
                ['disabled_at', 'IS NOT NULL'],
                ['disabled_by', 'IS NOT NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->enable()) {
            Form::setState('Cannot enable the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully enabled', 'The department will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Restore the department.
     */
    public static function restoreDepartment()
    {
        if (!Permission::can('restore-department')) {
            Form::setState('Cannot restore the department. Please try again later', 'You are not authorized to restore the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Form::getFieldData('restore_department')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->restore()) {
            Form::setState('Cannot restore the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully restored', 'The department will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Purge the department.
     */
    public static function purgeDepartment()
    {
        if (!Permission::can('purge-department')) {
            Form::setState('Cannot purge the department. Please try again later', 'You are not authorized to purge the department.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_departments')
            ->where([
                ['id', '=', Form::getFieldData('purge_department')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->purge()) {
            Form::setState('Cannot purge the department. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('Department has been successfully purged', 'The department will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Display the list of genders as radio.
     *
     * @param string $name
     * @param string || array $default_data
     * @param bool $required
     * @param bool $disabled
     */
    public static function displayGenderRadio($name, $default_data = null, $required = false, $disabled = false)
    {
        Datalist::displayRadio(['name'], $name, Database::table('umg_genders')
            ->select([
                'id',
                'name',
            ])
            ->fetchAll(), $default_data, $required, $disabled);
    }

    /**
     * Display the list of users as select box.
     *
     * @param string || array $default_data
     */
    public static function displayUserSelect($default_data = null)
    {
        Datalist::displaySelect(['name'], Database::table('umg_users')
            ->where([
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->select([
                'id', //KUKUNING VALUE SA SELECT
                Database::concat([
                    'first_name',
                    "' '",
                    'last_name',
                ], 'name'),
                'disabled_at',
                'disabled_by',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of users as select box.
     *
     * @param string || array $default_data
     */
    public static function displayFacultySelect($default_data = null)
    {
        Datalist::displaySelect(['professor'], Database::table('umg_users_roles a')
            ->leftJoin([
              'umg_users b' => [
                'a.user_id = b.id'
              ]
            ])
            ->where([
                ['a.role_id', '=', '2'], //select all faculty
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->select([
                'b.id', //KUKUNING VALUE SA SELECT
                Database::concat([
                    'b.first_name',
                    "' '",
                    'b.last_name',
                ], 'professor'),
                'disabled_at',
                'disabled_by',
            ])
            ->fetchAll(), $default_data);
    }

    /**
     * Display the list of users as table.
     */
    public static function displayUserTable()
    {
        switch (Route::currentData()) {
            case 'created':
                Datalist::displayTable([
                    'id'              => 'ID',
                    'username'        => 'USERNAME',
                    'first_name'      => 'FIRST NAME',
                    'middle_name'     => 'MIDDLE NAME',
                    'last_name'       => 'LAST NAME',
                    'roles'           => 'ROLE(S)',
                ], Database::table('umg_users a')
                    ->where([
                        ['a.disabled_at', 'IS NULL'],
                        ['a.disabled_by', 'IS NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->show(100)
                    ->select([
                        'a.id',
                        'a.username',
                        'a.first_name',
                        'a.middle_name',
                        'a.last_name',
                        Database::plain(0)
                            ->table('umg_users_roles', 0)
                            ->leftJoin([
                                'umg_roles' => [
                                    'umg_users_roles.role_id = umg_roles.id'
                                ],
                            ], 0)
                            ->where([
                                ['umg_users_roles.user_id', '=', 'a.id'],
                                ['umg_roles.deleted_at', 'IS NULL'],
                                ['umg_roles.deleted_by', 'IS NULL'],
                            ], 0)
                            ->select([
                                Database::groupConcat([
                                    Database::condition('umg_roles.disabled_at IS NULL AND umg_roles.disabled_by IS NULL', "' '", "' text-disabled'"),
                                    'umg_roles.name',
                                ], "' '"),
                            ], 0, 'roles'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('view-user')) {
                            $action .= "<form>
                                          <a class='btn btn-warning btn-xs' href='" . Route::getURL('view-user', $id) . "' title='" . Route::getName('view-user')  . "'>" . Route::getIcon('view-user')  . "</a>
                                        </form>";
                        }

                        if (Permission::can('reset-user-password')) {
                            $action .= "<form method='POST'>
                                          <a class='btn btn-primary btn-xs' href='" . Route::getURL('reset-user-password', $id) . "' title='" . Route::getName('reset-user-password')  . "'>" . Route::getIcon('reset-user-password') . "</a>
                                        </form>";
                        }

                        if (Permission::can('edit-user')) {
                            $action .= "<form method='POST'>
                                          <a class='btn btn-success btn-xs' href='" . Route::getURL('edit-user', $id) . "' title='" . Route::getName('edit-user')  . "'>" . Route::getIcon('edit-user') . "</a>
                                        </form>";
                        }

                        if (Permission::can('disable-user')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='disable_user' title='" . Route::getName('disable-user')  . "' type='submit' value='{$id}'>" . Route::getIcon('disable-user') . "</button>
                                        </form>";
                        }

                        if (Permission::can('delete-user')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-danger btn-xs' name='delete_user' title='" . Route::getName('delete-user')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-user') . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'disabled':
                Datalist::displayTable([
                    'id'              => 'ID',
                    'username'        => 'USERNAME',
                    'first_name'      => 'FIRST NAME',
                    'middle_name'     => 'MIDDLE NAME',
                    'last_name'       => 'LAST NAME',
                    'roles'           => 'ROLE(S)',
                    'disabled_by'     => 'DISABLED BY',
                ], Database::table('umg_users a')
                    ->where([
                        ['a.disabled_at', 'IS NOT NULL'],
                        ['a.disabled_by', 'IS NOT NULL'],
                        ['a.deleted_at', 'IS NULL'],
                        ['a.deleted_by', 'IS NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.username',
                        'a.first_name',
                        'a.middle_name',
                        'a.last_name',
                        Database::plain(0)
                            ->table('umg_users_roles', 0)
                            ->leftJoin([
                                'umg_roles' => [
                                    'umg_users_roles.role_id = umg_roles.id'
                                ],
                            ], 0)
                            ->where([
                                ['umg_users_roles.user_id', '=', 'a.id'],
                                ['umg_roles.deleted_at', 'IS NULL'],
                                ['umg_roles.deleted_by', 'IS NULL'],
                            ], 0)
                            ->select([
                                Database::groupConcat([
                                    Database::condition('umg_roles.disabled_at IS NULL AND umg_roles.disabled_by IS NULL', "' '", "' text-disabled'"),
                                    'umg_roles.name',
                                ], "' '"),
                            ], 0, 'roles'),
                        Database::getDisabler('a.disabled_at', 'a.disabled_by', 'disabled_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('enable-user')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='enable_user' title='" . Route::getName('enable-user')  . "' type='submit' value='{$id}'>" . Route::getIcon('enable-user')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('delete-user')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='delete_user' title='" . Route::getName('delete-user')  . "' type='submit' value='{$id}'>" . Route::getIcon('delete-user')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            case 'deleted':
                Datalist::displayTable([
                    'id'              => 'ID',
                    'username'        => 'USERNAME',
                    'first_name'      => 'FIRST NAME',
                    'middle_name'     => 'MIDDLE NAME',
                    'last_name'       => 'LAST NAME',
                    'roles'           => 'ROLE(S)',
                    'deleted_by'      => 'DELETED BY',
                ], Database::table('umg_users a')
                    ->where([
                        ['a.deleted_at', 'IS NOT NULL'],
                        ['a.deleted_by', 'IS NOT NULL'],
                    ])
                    ->select([
                        'a.id',
                        'a.username',
                        'a.first_name',
                        'a.middle_name',
                        'a.last_name',
                        Database::plain(0)
                            ->table('umg_users_roles', 0)
                            ->leftJoin([
                                'umg_roles' => [
                                    'umg_users_roles.role_id = umg_roles.id'
                                ],
                            ], 0)
                            ->where([
                                ['umg_users_roles.user_id', '=', 'a.id'],
                                ['umg_roles.deleted_at', 'IS NULL'],
                                ['umg_roles.deleted_by', 'IS NULL'],
                            ], 0)
                            ->select([
                                Database::groupConcat([
                                    Database::condition('umg_roles.disabled_at IS NULL AND umg_roles.disabled_by IS NULL', "' '", "' text-disabled'"),
                                    'umg_roles.name',
                                ], "' '"),
                            ], 0, 'roles'),
                        Database::getDeleter('a.deleted_at', 'a.deleted_by', 'deleted_by'),
                    ])
                    ->fetchAll(), function ($id) {
                        $action = '';

                        if (Permission::can('restore-user')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='restore_user' title='" . Route::getName('restore-user')  . "' type='submit' value='{$id}'>" . Route::getIcon('restore-user')  . "</button>
                                        </form>";
                        }

                        if (Permission::can('purge-user')) {
                            $action .= "<form method='POST'>
                                          <button class='btn btn-default btn-xs' name='purge_user' title='" . Route::getName('purge-user')  . "' type='submit' value='{$id}'>" . Route::getIcon('purge-user')  . "</button>
                                        </form>";
                        }

                        return $action;
                    });
                break;
            default:
        }
    }

    /**
     * Validate the user.
     */
    public static function validateUser()
    {
        if (!Database::table('umg_users')
            ->where([
                ['id', '=', Route::currentData()],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])

            ->select()
            ->fetch()) {
            Route::go(Route::getParent(Route::current()));
        }
    }

    /**
     * Load the user data.
     */
    public static function loadUserData()
    {
        self::$role_data = Database::table('umg_users a')
            ->where([
                ['a.id', '=', Route::currentData()],
            ])
            ->select([
                'a.id',
                'a.username',
                'a.first_name',
                'a.middle_name',
                'a.last_name',
                Database::dateFormat('a.birthdate', '\'%M %d, %Y\'', 'birthdate'),
                Database::plain(0)
                    ->table('umg_genders', 0)
                    ->where([
                        ['umg_genders.id', '=', 'a.gender_id'],
                    ], 0)
                    ->select([
                        Database::concat([
                            'umg_genders.name',
                        ], "' '"),
                    ], 0, 'gender'),
                Database::plain(0)
                    ->table('umg_users_email_addresses', 0)
                    ->where([
                        ['umg_users_email_addresses.user_id', '=', 'a.id'],
                    ], 0)
                    ->select([
                        Database::groupConcat([
                            'umg_users_email_addresses.email_address',
                        ], "' '"),
                    ], 0, 'email_addresses'),
                Database::plain(0)
                    ->table('umg_users_departments', 0)
                    ->leftJoin([
                        'umg_departments' => [
                            'umg_users_departments.department_id = umg_departments.id'
                        ],
                    ], 0)
                    ->where([
                        ['umg_users_departments.user_id', '=', 'a.id'],
                    ], 0)
                    ->select([
                        Database::groupConcat([
                            Database::condition('umg_departments.disabled_at IS NULL AND umg_departments.disabled_by IS NULL', "' '", "' text-disabled'"),
                            'umg_departments.name',
                        ], "' '"),
                    ], 0, 'departments'),
                Database::plain(0)
                    ->table('umg_users_roles', 0)
                    ->leftJoin([
                        'umg_roles' => [
                            'umg_users_roles.role_id = umg_roles.id'
                        ],
                    ], 0)
                    ->where([
                        ['umg_users_roles.user_id', '=', 'a.id'],
                    ], 0)
                    ->select([
                        Database::groupConcat([
                            Database::condition('umg_roles.disabled_at IS NULL AND umg_roles.disabled_by IS NULL', "' '", "' text-disabled'"),
                            'umg_roles.name',
                        ], "' '"),
                    ], 0, 'roles'),
                Database::getCreator('a.created_at', 'a.created_by', 'created_by'),
                Database::getUpdater('a.updated_at', 'a.updated_by', 'updated_by'),
            ])
            ->fetch();
    }

    /**
     * Display the role data.
     *
     * @param string $data
     */
    public static function displayUserData($data)
    {
        echo self::$role_data[$data] ? self::$role_data[$data] : '<span class=\'text-muted\'>' . Placeholder::get('long') . '</span>' ;
    }

    /**
     * Load the user field data.
     */
    public static function loadUserFieldData()
    {
        if ($data = Database::table('umg_users')
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->select()
            ->fetch()) {
            Form::createFieldData('username', $data['username']);
            Form::createFieldData('first_name', $data['first_name']);
            Form::createFieldData('middle_name', $data['middle_name']);
            Form::createFieldData('last_name', $data['last_name']);
            Form::createFieldData('birthdate', $data['birthdate']);
            Form::createFieldData('gender', $data['gender_id']);
        }

        if ($data = Database::table('umg_users_email_addresses')
            ->where([
                ['user_id', '=', Route::currentData()],
            ])
            ->select([
                'email_address',
            ])
            ->fetchAll()) {
            Form::createFieldData('email_addresses', implode(',', array_column($data, 'email_address')));
        }

        if ($data = Database::table('umg_users_departments a')
            ->leftJoin([
                'umg_departments b' => [
                    'a.department_id = b.id'
                ],
            ])
            ->where([
                ['a.user_id', '=', Route::currentData()],
                ['b.disabled_at', 'IS NULL'],
                ['b.disabled_by', 'IS NULL'],
                ['b.deleted_at', 'IS NULL'],
                ['b.deleted_by', 'IS NULL'],
            ])
            ->select([
                'a.department_id',
            ])
            ->fetchAll()) {
            Form::createFieldData('departments', array_column($data, 'department_id'));
        }

        if ($data = Database::table('umg_users_roles a')
            ->leftJoin([
                'umg_roles b' => [
                    'a.role_id = b.id'
                ],
            ])
            ->where([
                ['a.user_id', '=', Route::currentData()],
                ['b.disabled_at', 'IS NULL'],
                ['b.disabled_by', 'IS NULL'],
                ['b.deleted_at', 'IS NULL'],
                ['b.deleted_by', 'IS NULL'],
            ])
            ->select([
                'a.role_id',
            ])
            ->fetchAll()) {
            Form::createFieldData('roles', array_column($data, 'role_id'));
        }
    }

    /**
     * Add a new user.
     */
    public static function addNewUser()
    {
        if (!Permission::can('add-new-user')) {
            Form::setState('Cannot add a new user. Please try again later', 'You are not authorized to add new user.', Form::ALERT_ERROR, true);
            return;
        }

        Database::beginTransaction();

        if (Database::table('umg_users')
            ->where([
                ['username', '=', Form::getFieldData('username')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('username', 'Username already exist.', Form::VALIDATION_ERROR);
            return;
        }

        if (Form::getFieldData('password') != Form::getFieldData('confirm_password')) {
            Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('confirm_password', 'Password does not match.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_users')
            ->values([
                ['username', Form::getFieldData('username')],
                ['password', Form::getFieldData('password')],
                ['first_name', Form::getFieldData('first_name')],
                ['middle_name', Form::getFieldData('middle_name')],
                ['last_name', Form::getFieldData('last_name')],
                ['birthdate', Form::getFieldData('birthdate')],
                ['gender_id', Form::getFieldData('gender')],
            ])
            ->insert()) {
            Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        $user_id = Database::lastInsertId();

        if (Form::getFieldData('email_addresses')) {
            foreach (explode(',', Form::getFieldData('email_addresses')) as $email_address) {
                if (!Database::table('umg_users_email_addresses')
                    ->values([
                        ['user_id', $user_id],
                        ['email_address', $email_address],
                    ])
                    ->insert()) {
                    Form::setState('Cannot add a new user. Please try again later', 'Somethingss went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (Form::getFieldData('departments')) {
            foreach (Form::getFieldData('departments') as $department_id) {
                if (!Database::table('umg_users_departments')
                    ->values([
                        ['user_id', $user_id],
                        ['department_id', $department_id],
                    ])
                    ->insert()) {
                    Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (Form::getFieldData('roles')) {
            foreach (Form::getFieldData('roles') as $role_id) {
                if (!Database::table('umg_users_roles')
                    ->values([
                        ['user_id', $user_id],
                        ['role_id', $role_id],
                    ])
                    ->insert()) {
                    Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (!Database::commit()) {
            Form::setState('Cannot add a new user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully added.', 'The user will now be available in the system..', Form::ALERT_SUCCESS, true);
        Route::go(Route::getParent(Route::current()));
    }

    public static function importUser()
    {
        if (!Permission::can('import-user')) {
            Form::setState('Cannot import the user. Please try again later', 'You are not authorized to import the user.', Form::ALERT_ERROR, true);
            return;
        }

        Database::beginTransaction();

        /*
        if (!Database::table('clm_classes')
            ->set([
                ['imported_at', 'NOW()'],
                ['imported_by', Authentication::getAuthenticatedUser()],
            ])
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->update()) {
            Form::setState('Cannot import the class. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }
        */

        if (!in_array(Form::getFieldFile('class_list', 'type'), ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'xls', 'xlsx'])) {
            Form::setState('Cannot import the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('class_list', 'File must be a proper excel file.', Form::VALIDATION_ERROR);
            return;
        }

        $official_class_list = \PHPExcel_IOFactory::createReader('Excel5')
            ->load(Form::getFieldFile('class_list', 'tmp_name'))
            ->getSheet(0);

        for ($row = 7; $row <= $official_class_list->getHighestRow() - 15; $row++) {
            $student = $official_class_list->rangeToArray("A{$row}:D{$row}", null, true, false)[0];

            if (!in_array($student[0], ['Boys', 'Girls'])) {
                $student_number = $student[1];
                $first_name = explode(',', $student[2])[1];
                $last_name = explode(',', $student[2])[0];

                if (!Database::table('umg_users')
                    ->values([
                        ['username', $student_number],
                        ['password', Security::encryptPassword(strtoupper($last_name))],
                        ['first_name', ucwords(strtolower($first_name))],
                        ['last_name', ucwords(strtolower($last_name))],
                    ])
                    ->insert()) {
                    Form::setState('Cannot import the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }

                $user_id = Database::lastInsertId();

                $department_id = Database::table('acd_courses')
                    ->where([
                        ['name', '=', $student[3]],
                    ])
                    ->select([
                        'department_id',
                    ])
                    ->fetch()['department_id'];

                if (!Database::table('umg_users_departments')
                    ->values([
                        ['user_id', $user_id ],
                        ['department_id', $department_id],
                    ])
                    ->insert()) {
                    Form::setState('Cannot import the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }

                //import students
                if (!Database::table('umg_users_roles')
                    ->values([
                        ['user_id', $user_id ],
                        ['role_id', 5],
                    ])
                    ->insert()) {
                    Form::setState('Cannot import the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (!Database::commit()) {
            Form::setState('Cannot import the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully imported', 'The user will now be imported.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }


    /**
     * Reset a user password.
     */
    public static function resetUserPassword()
    {
        if (!Permission::can('reset-user-password')) {
            Form::setState('Cannot reset the user password. Please try again later', 'You are not authorized to reset the user password.', Form::ALERT_ERROR, true);
            return;
        }

        if (Form::getFieldData('new_password') != Form::getFieldData('confirm_new_password')) {
            Form::setState('Cannot reset the user password. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('confirm_new_password', 'Password does not match.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_users')
            ->set([
                ['password', Security::encryptPassword(Form::getFieldData('new_password'))],
            ])
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->update()) {
            Form::setState('Cannot reset the user password. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User password has been successfully reset', 'The user can now sign in using the new password.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Edit the user.
     */
    public static function editUser()
    {
        if (!Permission::can('edit-user')) {
            Form::setState('Cannot edit the user. Please try again later', 'You are not authorized to edit the user.', Form::ALERT_ERROR, true);
            return;
        }

        Database::beginTransaction();

        if (Database::table('umg_users')
            ->where([
                ['id', '!=', Route::currentData()],
                ['username', '=', Form::getFieldData('username')],
            ])
            ->select()
            ->fetch()) {
            Form::setState('Cannot edit the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            Form::setFieldState('username', 'Username already exist.', Form::VALIDATION_ERROR);
            return;
        }

        if (!Database::table('umg_users')
            ->set([
                ['username', Form::getFieldData('username')],
                ['first_name', Form::getFieldData('first_name')],
                ['middle_name', Form::getFieldData('middle_name')],
                ['last_name', Form::getFieldData('last_name')],
                ['birthdate', Form::getFieldData('birthdate')],
                ['gender_id', Form::getFieldData('gender')],
            ])
            ->where([
                ['id', '=', Route::currentData()],
            ])
            ->update()) {
            Form::setState('Cannot edit the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_users_email_addresses')
            ->where([
                ['user_id', '=', Route::currentData()],
            ])
            ->purge()) {
            Form::setState('Cannot edit the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        if (Form::getFieldData('email_addresses')) {
            foreach (explode(',', Form::getFieldData('email_addresses')) as $email_address) {
                if (!Database::table('umg_users_email_addresses')
                    ->values([
                        ['user_id', Route::currentData()],
                        ['email_address', $email_address],
                    ])
                    ->insert()) {
                    Form::setState('Cannot edit the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (!Database::table('umg_users_departments')
            ->where([
                ['user_id', '=', Route::currentData()],
            ])
            ->purge()) {
            Form::setState('Cannot edit the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        if (Form::getFieldData('departments')) {
            foreach (Form::getFieldData('departments') as $department_id) {
                if (!Database::table('umg_users_departments')
                    ->values([
                        ['user_id', Route::currentData()],
                        ['department_id', $department_id],
                    ])
                    ->insert()) {
                    Form::setState('Cannot edit the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (!Database::table('umg_users_roles')
            ->where([
                ['user_id', '=', Route::currentData()],
            ])
            ->purge()) {
            Form::setState('Cannot edit the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        if (Form::getFieldData('roles')) {
            foreach (Form::getFieldData('roles') as $role_id) {
                if (!Database::table('umg_users_roles')
                    ->values([
                        ['user_id', Route::currentData()],
                        ['role_id', $role_id],
                    ])
                    ->insert()) {
                    Form::setState('Cannot edit the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
                    return;
                    break;
                }
            }
        }

        if (!Database::commit()) {
            Form::setState('Cannot edit the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully edited', 'The user will now be updated in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Disable the user.
     */
    public static function disableUser()
    {
        if (!Permission::can('disable-user')) {
            Form::setState('Cannot disable the user. Please try again later', 'You are not authorized to disable the user.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_users')
            ->where([
                ['id', '=', Form::getFieldData('disable_user')],
                ['disabled_at', 'IS NULL'],
                ['disabled_by', 'IS NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->disable()) {
            Form::setState('Cannot disable the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully disabled', 'The user will no longer be available but will still appear in the system.', Form::ALERT_SUCCESS, true);

        Route::go(Route::getParent(Route::current()));
    }

    /**
     * Delete the user.
     */
    public static function deleteUser()
    {
        if (!Permission::can('delete-user')) {
            Form::setState('Cannot delete the user. Please try again later', 'You are not authorized to delete the user.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_users')
            ->where([
                ['id', '=', Form::getFieldData('delete_user')],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->delete()) {
            Form::setState('Cannot delete the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully deleted', 'The user will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Enable the user.
     */
    public static function enableUser()
    {
        if (!Permission::can('enable-user')) {
            Form::setState('Cannot enable the user. Please try again later', 'You are not authorized to enable the user.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_users')
            ->where([
                ['id', '=', Form::getFieldData('enable_user')],
                ['disabled_at', 'IS NOT NULL'],
                ['disabled_by', 'IS NOT NULL'],
                ['deleted_at', 'IS NULL'],
                ['deleted_by', 'IS NULL'],
            ])
            ->enable()) {
            Form::setState('Cannot enable the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully enabled', 'The user will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Restore the user.
     */
    public static function restoreUser()
    {
        if (!Permission::can('restore-user')) {
            Form::setState('Cannot restore the user. Please try again later', 'You are not authorized to restore the user.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_users')
            ->where([
                ['id', '=', Form::getFieldData('restore_user')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->restore()) {
            Form::setState('Cannot restore the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully restored', 'The user will now be available in the system..', Form::ALERT_SUCCESS, true);

        Route::reload();
    }

    /**
     * Purge the user.
     */
    public static function purgeUser()
    {
        if (!Permission::can('purge-user')) {
            Form::setState('Cannot purge the the user. Please try again later', 'You are not authorized to purge the user.', Form::ALERT_ERROR, true);
            return;
        }

        if (!Database::table('umg_users')
            ->where([
                ['id', '=', Form::getFieldData('purge_user')],
                ['deleted_at', 'IS NOT NULL'],
                ['deleted_by', 'IS NOT NULL'],
            ])
            ->purge()) {
            Form::setState('Cannot purge the the user. Please try again later', 'Something went wrong during the process.', Form::ALERT_ERROR, true);
            return;
        }

        Form::setState('User has been successfully purged', 'The user will no longer be available in the system.', Form::ALERT_SUCCESS, true);

        Route::reload();
    }
}
