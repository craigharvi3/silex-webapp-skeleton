<?php

namespace CH\Skeleton;

use Pimple\Container;
use Silex\Api\BootableProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ViewController
 *
 * Controls a "Page" and provides the ORB and Radionav.
 *
 * @package     CH\Skeleton
 * @author      Craig Harvie <harvie5@msn.com>
 * @copyright   Craig Harvie
 */
abstract class ViewController extends Controller
{
    public function register(Container $pimple)
    {
        /* @var     Application     $pimple     */
        parent::register($pimple);

        //
        // Register to Twig:
        //
        $pimple->extend('twig.loader.filesystem', function (\Twig_Loader_Filesystem $loader) {
            // And add in this view controllers views:
            $reflected = new \ReflectionClass($this);
            // The view directory is above the controller in a flat structure
            // when using folders its a level above
            $directory = dirname($reflected->getFileName());
            $path = realpath($directory.'/..');
            if (!is_dir($path . '/views')) {
                $path = realpath($directory.'/../..');
            }

            if (file_exists($path.'/views')) {
                $loader->addPath($path.'/views', $this->getName());
            }
            return $loader;
        });

        //
        // Add in the after handler to set the correct cache headers:
        //
        $pimple->after(function (Request $request, Response $response) use ($pimple) {
            // This header is needed to allow Varnish to pass through the language
            // headers to our app.
            $response->setVary('X-CDN, X-COOKIE-ckps_language');

            // We also set an x-cache-debug header here on lower environments to
            // be able to see what values were actually sent since Varnish will
            // strip them due to the Vary.
            if ($pimple->getEnvironment() !== Application::ENV_LIVE) {
                $response->headers->set('x-cache-debug', $response->headers->get('Cache-Control'));
            }
        });
    }

    /**
     * Renders a "full page" (orb and radionav included).
     *
     * @param   string  $template
     * @param   array   $viewData
     * @return  string
     */
    public function renderPage(string $template, array $viewData = []): string
    {
        $viewData['locale'] = $this->locale;
        return $this->app['twig']->render($template, $viewData);
    }
}
