<?php

namespace CH\Skeleton;

/**
 * Class Application
 *
 * Small wrapper around the Silex core application which adds things like environment detection.
 *
 * @package     CH\Skeleton
 * @author      Craig Harvie <harvie5@msn.com>
 * @copyright   Craig Harvie
 */
class Application extends \Silex\Application
{

    const ENV_LOCAL = 'local';
    const ENV_UNITTESTS = 'unittests';
    const ENV_INT = 'int';
    const ENV_TEST = 'test';
    const ENV_STAGE = 'stage';
    const ENV_LIVE = 'live';

    /**
     * @var     string      Environment name
     */
    protected $env;

    /**
     * @var     ComponentConfiguration
     */
    protected $componentConfig;

    /**
     * Sets the component configuration of this application
     *
     * @param   ComponentConfiguration  $config
     * @return  $this
     */
    public function setComponentConfiguration(ComponentConfiguration $config)
    {
        $this->componentConfig = $config;
        return $this;
    }

    /**
     * Returns the ComponentConfiguration object the app is currently using.
     *
     * @return  ComponentConfiguration
     */
    public function getComponentConfiguration()
    {
        return $this->componentConfig;
    }

    /**
     * Returns the name of this application.
     *
     * @return  string
     */
    public function getName()
    {
        if (isset($this->componentConfig)) {
            return $this->componentConfig->getAppName();
        }
        return null;
    }

    /**
     * Forces a particular environment to be used over any other config defined.
     *
     * @param   string  $env
     * @return  $this
     */
    public function setEnvironment($env)
    {
        $this->env = $env;
        return $this;
    }

    /**
     * Returns the version of this application, read in from the environment variables on the server.
     *
     * @return  string
     */
    public function getVersion()
    {
        if (isset($this->componentConfig)) {
            return $this->componentConfig->getRelease();
        }
        return false;
    }
    
    /*
     * ---------------------- Protected Helpers ------------------------
     */

    /**
     * Reads an environment variable. Includes a sneaky check to $_ENV to allow for the
     * unit tests to influence the environment.
     *
     * @param   string $name Environment variable name.
     * @return  mixed
     * @codeCoverageIgnore
     */
    protected function readEnv($name)
    {
        return (array_key_exists($name, $_ENV)) ? $_ENV[$name] : getenv($name);
    }

    /**
     * This array allows you to override the environment for certain hostnames. Useful for the staging
     * environment and if people have strange local setups.
     *
     * @var     array
     */
    protected $hostnames =  [
        self::ENV_LOCAL => [
            'local.bbc.co.uk',
            'localhost',
            '127.0.0.1'
        ],
        self::ENV_STAGE => []
    ];

    /**
     * Returns the application environment. You should not string compare this value,
     * use the class constants instead, ie:
     *
     *  if ($app->environment() == Application::ENV_LOCAL)
     *
     * @return  string
     */
    public function getEnvironment(): string
    {
        if (isset($this->env)) {
            return $this->env;
        }

        // Check for hostname overrides:
        if (array_key_exists('HTTP_HOST', $_SERVER)) {
            foreach ($this->hostnames as $env => $hostnames) {
                if (in_array($_SERVER['HTTP_HOST'], $hostnames)) {
                    return $env;
                }
            }
        }

        // Now read component config if present:
        if (isset($this->componentConfig)) {
            return $this->componentConfig->getEnvironment();
        }

        // Final check: let's see about environment variables:
        return $this->readEnv('APP_ENV')?: self::ENV_LIVE;
    }
}
