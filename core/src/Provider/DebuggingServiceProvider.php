<?php

namespace CH\Skeleton\Provider;

use CH\Skeleton\Provider\WebProfilerServiceProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\HttpFragmentServiceProvider;
use Symfony\Component\Stopwatch\Stopwatch;
/**
 * Class DebuggingServiceProvider
 *
 * Adds in the debugbar, fixtures and other debugging tools.
 *
 * @package     RMP\Base\Provider
 * @author      Alex Gisby <alex.gisby@bbc.co.uk>
 * @copyright   BBC
 */
class DebuggingServiceProvider implements ServiceProviderInterface
{
    /**
     * @var bool
     */
    protected $enableToolbar = true;
    
    /**
     * Whether the toolbar is enabled or not.
     *
     * @param   bool  $enabled
     * @return  $this
     */
    public function setToolbarEnabled($enabled)
    {
        $this->enableToolbar = (bool)$enabled;
        return $this;
    }

    /**
     * Returns whether the toolbar is enabled or not.
     *
     * @return  bool
     */
    public function isToolbarEnabled()
    {
        return $this->enableToolbar;
    }

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
        $pimple['debugging.profiler.hostname'] = null;
        $this->registerDebugBar($pimple);
    }

    /**
     * Registers the debug-bar, if allowed
     *
     * @param   Container   $pimple
     * @return  void
     */
    protected function registerDebugBar(Container $pimple)
    {
        if ($pimple['debug'] && $this->enableToolbar) {
            $pimple->register(new HttpFragmentServiceProvider());
            $pimple->register(
                (new WebProfilerServiceProvider())
                    ->setProfilerHostname($pimple['debugging.profiler.hostname']),
                array(
                    'profiler.cache_dir' => $pimple['config']->get('core.profiler.cache_dir'),
                    'profiler.mount_prefix' => '/_profiler',
                )
            );
        } else {
            //
            // Without the debugbar we need to manually register a stopwatch.
            //
            $pimple['stopwatch'] = function () {
                return new Stopwatch();
            };
        }
    }
}