<?php

namespace CH\Skeleton\Provider;

use Silex\Application;

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