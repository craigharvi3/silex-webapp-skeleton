<?php

namespace CH\Skeleton\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use CH\Skeleton\Application;
use CH\Skeleton\Provider\DebuggingServiceProvider;
use CH\Skeleton\Provider\RenderingServiceProvider;
use CH\Skeleton\Provider\ViewRenderingServiceProvider;
use CH\Skeleton\Provider\BasicServiceProvider;
use Solution10\Config\Config;

/**
 * Class CoreServiceProvider
 *
 * Bootstraps the core of Skeleton. Most of this is handled in RMP-Base
 * but there's some specific stuff for Skeleton.
 *
 * @codeCoverageIgnore
 */
class CoreServiceProvider implements ServiceProviderInterface
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
        /* @var     \Radio\Skeleton\Application  $pimple     */

        //
        // Register the service providers needed by Skeleton:
        //
        $pimple
            ->register(new \CH\Skeleton\Provider\ConfigServiceProvider())
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
            ->register(new RenderingServiceProvider());

        // We have to work out a bit of config for the Debugging service provider:
        $debugProvider = new DebuggingServiceProvider();
        $debugProvider->setToolbarEnabled(true);

        $pimple->register($debugProvider);

        $pimple->extend('twig.loader.filesystem', function (\Twig_Loader_Filesystem $loader) {
            // And add in the 'core' view path:
            $loader->addPath(__DIR__ . '/../../views', 'core');
            $loader->addPath(__DIR__ . '/../../../app/Home/views', 'home');
            return $loader;
        });
    }
}
