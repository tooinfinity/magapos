<?php

return [
    'create_users' => false,
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'employer' => [
            'profile' => 'r,u',
        ],
    ],

    'permission_structure' => [],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
