<?php

namespace CH\Skeleton\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\TwigServiceProvider;

class ViewRenderingServiceProvider implements ServiceProviderInterface
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
        $pimple->register(new TwigServiceProvider(), [
            'twig.path' => __DIR__ . '/../../views',
            'twig.options' => $pimple['config']->get('twig')
        ]);
    }
}