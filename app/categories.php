<?php
/**
 * This will be the basis of the application which category does the routes
 * belong, you can freely register any route here.
 */
return [
    'home' => [
        'name'   => 'HOME',
        'icon'   => '<i class="glyphicon glyphicon-home"></i>',
        'routes' => [
            'dashboard'
        ],
    ],
    'user-management' => [
        'name'   => 'USER MANAGEMENT',
        'icon'   => '<i class="glyphicon glyphicon-user"></i>',
        'routes' => [
            'manage-permissions',
            'manage-roles',
            'manage-departments',
            'manage-users',
        ],
    ],
    'academics' => [
        'name'   => 'ACADEMICS',
        'icon'   => '<i class="glyphicon glyphicon-book"></i>',
        'routes' => [
            'manage-courses',
            'manage-subjects',
            'manage-sections',
            'manage-student-classes',
            'manage-classes',
            'manage-classlist'
        ],
    ],
    'attendance' => [
        'name'   => 'ATTENDANCE',
        'icon'   => '<i class="glyphicon glyphicon-time"></i>',
        'routes' => [
              'manage-attendance',
        ],
    ],
    'preferences' => [
        'name'   => 'SETTINGS',
        'icon'   => '<i class="glyphicon glyphicon-wrench"></i>',
        'routes' => [
            'manage-system-preferences',
        ],
    ],


];
