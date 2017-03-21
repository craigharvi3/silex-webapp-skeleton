<?php

namespace CH\Home;

use Silex\Application;
use CH\Skeleton\ViewController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeViewController extends ViewController
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'home';
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     *
     * @param   Application     $app
     */
    public function boot(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', $this->getAction('handleAction'))
            ->bind('home-page')
        ;

        $app->mount('/', $controllers);
    }

    public function handleAction(Request $request)
    {
        $tracks = [];
        $response = new Response($this->renderPage('@home/home.body.html.twig'));

        $response
            ->setPublic()
            ->setMaxAge($this->app['config']->get('home.cache-control.max-age'))
            ->setSharedMaxAge($this->app['config']->get('home.cache-control.s-maxage'))
        ;
        $response->headers->addCacheControlDirective(
            'stale-while-revalidate',
            $this->app['config']->get('home.cache-control.stale-while-revalidate')
        );

        return $response;
    }
}
