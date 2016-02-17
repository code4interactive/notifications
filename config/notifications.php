<?php
return [

    'defaultStore'   => 'session',
    'autoCleanOnGet' => true,

    'engine' => Code4\Notifications\Engines\BasicNotifications::class,

    'classes' => [
        'error'       => 'error',
        'notice'      => 'notice',
        'warning'     => 'warning',
        'success'     => 'success',
        'permissions' => 'permissions',
        'form'        => 'error'
    ],
    'icons'   => [
        'error'       => 'fa-times',
        'notice'      => 'fa-info',
        'warning'     => 'fa-exclamation',
        'success'     => 'fa-check',
        'permissions' => 'fa-lock',
        'form'        => 'fa-pencil-square-o'
    ]

];



