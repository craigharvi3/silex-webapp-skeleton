<?php

require_once __DIR__.'/../vendor/autoload.php';

function main()
{
    $app = new \CH\Skeleton\Application();

    //
    // Register Skeleton
    //
    $app->register(new \CH\Skeleton\Provider\CoreServiceProvider());

    //
    // Register the View controllers:
    //
    $app
        ->register(new \CH\Home\HomeViewController())
    ;

    //
    // Run the application:
    //
    $app->run();
};

main();
