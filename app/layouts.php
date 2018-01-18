<?php
use LPU\Path;

/**
 * This will be the basis of the application which layout will be used by the
 * routes, you can freely register any route here.
 */
return [
    'landing' => [
        'layout' => Path::getLayout('landing'),
        'routes' => [
            'login',
            'forgot-password',
            'reset-password',
        ],
    ],
    'main' => [
        'layout' => Path::getLayout('main'),
        'routes' => [
            'dashboard',
            'manage-my-account',
            'manage-system-preferences',
            'manage-permissions',
            'view-permission',
            'manage-roles',
            'view-role',
            'add-new-role',
            'edit-role',
            'manage-departments',
            'view-department',
            'add-new-department',
            'edit-department',
            'manage-users',
            'view-user',
            'add-new-user',
            'reset-user-password',
            'edit-user',
            'manage-courses',
            'view-course',
            'add-new-course',
            'edit-course',
            'manage-subjects',
            'view-subject',
            'add-new-subject',
            'edit-subject',
            'manage-sections',
            'view-section',
            'add-new-section',
            'edit-section',
            'manage-priorities',
            'view-priority',
            'add-new-priority',
            'edit-priority',
            'manage-services',
            'view-service',
            'add-new-service',
            'edit-service',
            'manage-units',
            'view-unit',
            'add-new-unit',
            'edit-unit',
            'manage-ticket-requests',
            'view-ticket-request',
            'add-new-ticket-request',
            'edit-ticket-request',
            'accomplish-ticket-request',
            'endorse-ticket-request',
            'manage-assigned-ticket-requests',
            'view-assigned-ticket-request',
            'accomplish-assigned-ticket-request',
            'manage-my-ticket-requests',
            'view-my-ticket-request',
            'request-for-ticket',
            'edit-my-ticket-request',
            'manage-computers',
            'view-computer',
            'add-new-computer',
            'edit-computer',
            'manage-laboratories',
            'view-laboratory',
            'add-new-laboratory',
            'edit-laboratory',
            'edit-laboratory-layout',
            'manage-classes',
            'view-class',
            'add-new-class',
            'edit-class',
            'manage-assigned-classes',
            'view-assigned-class',
            'import-assigned-class',
            'edit-assigned-class-seat-plan',
            'manage-internet-access-requests',
            'view-internet-access-request',
            'add-new-internet-access-request',
            'edit-internet-access-request',
            'remark-internet-access-request',
            'manage-my-internet-access-requests',
            'view-my-internet-access-request',
            'request-for-internet-access',
            'edit-my-internet-access-request',
            'manage-incident-reports',
            'view-incident-report',
            'add-new-incident-report',
            'edit-incident-report',
            'process-incident-report',
            'manage-my-incident-reports',
            'view-my-incident-report',
            'add-my-new-incident-report',
            'edit-my-incident-report',
            'manage-attendance',
            'add-new-attendance',
            'view-attendance',
            'edit-attendance',
            'delete-attendance',
            'import-user',
            'manage-classlist',
            'add-new-classlist',
            'edit-classlist',
            'delete-classlist',
            'view-classlist',
            'manage-student-classes',
            'add-new-student-classes',
            'edit-student-classes',
            'delete-student-classes',
            'import-student-classes',
            'export-faculty-attendance'
        ],
    ],
    'print' => [
        'layout' => Path::getLayout('print'),
        'routes' => [
            'print-assigned-class-waiver-seat-plan',
            'print-incident-report',
            'print-my-incident-report',
        ],
    ],
    'loading' => [
        'layout' => Path::getLayout('loading'),
        'routes' => [
            'logout',
        ]
    ],
];