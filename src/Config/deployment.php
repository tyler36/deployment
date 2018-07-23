<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tyler36/Deployment
    |--------------------------------------------------------------------------
    |
    */

    // Default environment type to use
    'default'   => 'test',

    // Extension to use of backup .ENV file
    'backupExt' => 'old',

    // Array of available environments in ['alias' => 'extension' ]
    'envs'      => [
        'demo'     => 'prod',
        'test'     => 'test',
        'local'    => 'local',
        'previous' => 'old',
    ],

    'commands' => [
        'php artisan down',
        'updateComposer',
        'php artisan clear-compiled',
        'php artisan cache:clear',
        'php artisan config:clear',
        'php artisan route:cache',
        'php artisan view:clear',
        'php artisan migrate --no-interaction --force',
        'php artisan up',
    ],
];
