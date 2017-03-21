<?php

namespace CH\Skeleton\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use CH\Skeleton\Application;
use Silex\Api\BootableProviderInterface;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;

/**
 * Class BasicServiceProvider
 *
 * @package     RMP\Base\Providers
 * @copyright   BBC
 */
class BasicServiceProvider implements ServiceProviderInterface, BootableProviderInterface
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
        // Set the debug level:
        //
        $pimple['debug'] = $pimple['config']->get('core.debug', false);

        //
        // Set a constant 'now' time
        //
        $pimple['now'] = function () use ($pimple) {
            return new \DateTime('now');
        };

        //
        // Other service providers:
        //
        $pimple->register(new SessionServiceProvider());
        $pimple->register(new ServiceControllerServiceProvider());
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     *
     * @param \Silex\Application $app
     */
    public function boot(\Silex\Application $app)
    {
        // Timezone:
        date_default_timezone_set('Europe/London');

        // Status route:
        $app->get($app['config']->get('app.status_route'), function () {
            return 'A-OK!';
        });
    }
}
