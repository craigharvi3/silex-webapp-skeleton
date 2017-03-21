<?php
namespace CH\Skeleton\Provider;

use Silex\Application;

/**
 * Class WebProfilerServiceProvider
 *
 * This override allows you to define the hostname of the web profiler.
 * This is useful when running behind BBC Varnish and the page you render
 * is on a different URL than the profiler itself. Will use $_SERVER['HTTP_HOST']
 * if no URL is provided.
 *
 * @package     RMP\Base\Providers
 * @author      Alex Gisby <alex.gisby@bbc.co.uk>
 * @copyright   BBC
 */

class WebProfilerServiceProvider extends \Silex\Provider\WebProfilerServiceProvider
{
    protected $profilerHostname = null;

    /**
     * Sets the hostname that the profiler is on.
     *
     * @param   string  $hostname
     * @return  $this
     */
    public function setProfilerHostname($hostname)
    {
        $this->profilerHostname = $hostname;
        return $this;
    }

    /**
     * @return  string|null
     */
    public function getProfilerHostname()
    {
        return $this->profilerHostname;
    }
    
    public function connect(Application $app)
    {
        /* @var     \Silex\ControllerCollection     $controllers    */
        $controllers = parent::connect($app);
        if ($this->profilerHostname) {
            $hostname = $this->profilerHostname;
        } else {
            $hostname = (array_key_exists('HTTP_HOST', $_SERVER))? $_SERVER['HTTP_HOST'] : null;
            // Trim any ports off:
            if ($hostname) {
                $parts = parse_url($hostname);
                $hostname = (array_key_exists('host', $parts))? $parts['host'] : $parts['path'];
            }
        }
        if ($hostname) {
            $controllers->host($hostname);
        }
        return $controllers;
    }
}