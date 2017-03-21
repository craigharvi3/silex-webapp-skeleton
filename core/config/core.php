<?php

return [
    'debug' => true,
    'profiler' => [
        'cache_dir' => '/tmp/cache/profiler'
    ],
    'aws'   => [
        'region' => 'eu-west-1',
    ],
    'thresholds' => [
        'slow-render' => 5000, // milliseconds taken before a package is considered 'slow' to render.
    ],
    'external' => [
        'window_api_host' => 'https://silexwebappskeleton.co.uk'
    ]
];
