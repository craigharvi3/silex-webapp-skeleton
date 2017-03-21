<?php

return [
    'debug' => true,
    'profiler' => [
        'cache_dir' => '/tmp/cache/profiler'
    ],
    'thresholds' => [
        // To save waiting forever for tests checking slow render:
        'slow-render' => 100
    ]
];
