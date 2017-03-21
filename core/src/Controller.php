<?php

namespace CH\Skeleton;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Solution10\Config\Config;
use Symfony\Component\HttpFoundation\Request;
use Silex\Api\BootableProviderInterface;

/**
 * Class Controller
 *
 * Works as a service provider for a given set of routes. Registers
 * itself into the DI container and allows you to bind routes.
 *
 * Extend from this base controller if you're not doing anything
 * with Views, otherwise extend from the ViewController or the
 * CompositorViewController.
 *
 * @package     CH\Skeleton
 * @author      Craig Harvie <harvie5@msn.com>
 * @copyright   Craig Harvie
 */
abstract class Controller implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * @var     Application
     */
    protected $app;

    /**
     * @var     Locale
     */
    protected $locale;

    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * Registers this controller to the DI container.
     *
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        $this->app = $pimple;

        // Register this controller:
        $pimple[$this->getDIKey()] = function () {
            return $this;
        };

        /* @var     Config  $config */
        $config = $this->app['config'];
        $ref = new \ReflectionClass($this);
        $path = dirname($ref->getFileName()).'/../config';
        if (file_exists($path)) {
            $config->addBasePath($path);
        }

        // Make sure the locale is registered:
        $pimple->before(function (Request $request) {
            $this->initLocale($request);
        });
    }

    /**
     * Returns the DI key for this controller
     *
     * @return  string
     */
    public function getDIKey(): string
    {
        return 'silex-webapp-skeleton.controller.'.$this->getName();
    }

    /**
     * Returns a reference to a given action on this controller
     * to be used in routing:
     *
     *      $app->get('/hello', $this->action('hello'))
     *
     * @param   string  $action     Action method name
     * @return  string
     */
    public function getAction(string $action): string
    {
        return $this->getDIKey().':'.$action;
    }

    /**
     * Initialize the translations.
     *
     * @param   Request     $request
     * @param   string      $defaultLanguage
     * @return  Locale
     */
    public function initLocale(Request $request, string $defaultLanguage = 'en'): Locale
    {
        if (!isset($this->locale)) {
            $this->locale = new Locale($request, $defaultLanguage);
        }

        return $this->locale;
    }

    /**
     * Returns the locale this controller is using, if set.
     *
     * @return  Locale|null
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
