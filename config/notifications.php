<?php
return [

    'defaultStore' => 'session',
    'autoCleanOnGet' => true,

    'engine' => Code4\Notifications\Engines\BasicNotifications::class,

    'classes'      => [
        'error'   => 'error',
        'notice'  => 'notice',
        'warning' => 'warning',
        'success' => 'success'
    ]

];