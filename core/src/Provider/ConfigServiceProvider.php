<?php

namespace CH\Skeleton\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use CH\Skeleton\Application;
use Solution10\Config\Config;


class ConfigServiceProvider implements ServiceProviderInterface
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
        //
        // Config system
        //
        $pimple['config'] = function () use ($pimple) {
            return new Config(
                __DIR__.'/../../config',
                ($pimple->getEnvironment() != Application::ENV_LIVE)? $pimple->getEnvironment() : null
            );
        };
    }
}