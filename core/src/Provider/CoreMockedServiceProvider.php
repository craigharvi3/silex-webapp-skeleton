<?php

namespace CH\Skeleton\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use CH\Skeleton\Application;
use CH\Skeleton\Provider\ConfigServiceProvider;
use CH\Skeleton\Provider\ViewRenderingServiceProvider;
use CH\Skeleton\Provider\DebuggingServiceProvider;
use CH\Skeleton\Provider\RenderingServiceProvider;
use CH\Skeleton\Provider\BasicServiceProvider;
use Solution10\Config\Config;

/**
 * Class CoreMockedServiceProvider
 *
 * Bootstraps for a unit test setup.
 *
 */
class CoreMockedServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        /* @var     \CH\Skeleton\Application  $pimple     */

        //
        // Register the service providers needed by Skeleton:
        //
        $pimple
            ->register(new ConfigServiceProvider())
        ;

        // Register core config now, early, so that everything after this has
        // something to work with.
        $pimple->extend('config', function (Config $config) {
            $config->addBasePath(__DIR__.'/../../config');
            return $config;
        });

        $pimple
            ->register(new BasicServiceProvider())
            ->register(new ViewRenderingServiceProvider())
            ->register(new RenderingServiceProvider())
            ->register(new DebuggingServiceProvider())
        ;

        $pimple->extend('twig.loader.filesystem', function (\Twig_Loader_Filesystem $loader) {
            // And add in the 'core' view path:
            $loader->addPath(__DIR__ . '/../../views', 'core');
            $loader->addPath(__DIR__ . '/../../../app/Home/views', 'home');
            return $loader;
        });
    }
}
