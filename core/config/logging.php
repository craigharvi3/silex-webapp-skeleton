<?php

use Monolog\Logger;

return [
    'logfile' => [
        'path'  => '/var/log/silex-webapp-skeleton/debug.log',
        'level' => Logger::WARNING,
    ],
    'other_handlers' => []
];
