<?php

namespace CH\Skeleton\Tests;

use CH\Skeleton\PHPUnit\CreateApplication;
use CH\Skeleton\PHPUnit\WebTestCase;
use CH\Skeleton\ViewController;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Silex\Api\BootableProviderInterface;

class ViewControllerTest extends WebTestCase
{
    use CreateApplication;

    protected function getController(): ViewController
    {
        return new class extends ViewController implements BootableProviderInterface {
            public function getName(): string
            {
                return 'dummy-controller';
            }

            public function boot(Application $app)
            {
                $app->get('/', function (Request $request) {
                    return $this->renderPage('@dummy-controller/basic-compositor.html.twig');
                })->bind('dummy-dum-dums');
            }
        };
    }

    public function testRegister()
    {
        $app = $this->createApplication();
        $controller = $this->getController();

        $controller->register($app);

        // Assert that the views path has been registered:
        /* @var     \Twig_Loader_Filesystem  $loader     */
        $loader = $app['twig.loader.filesystem'];
        $this->assertEquals(
            realpath(__DIR__.'/../views'),
            realpath($loader->getPaths('core')[0])
        );
    }

    // public function testRenderPage()
    // {
    //     $this->createApplication();

    //     $client = $this->createClient();
    //     $this->createdApp
    //         ->register($this->getController());

    //     $client->request('GET', '/');
    //     $result = (string) $client->getResponse();
    //     print_r($client->getResponse());
    //     $this->assertTrue($client->getResponse()->isOk());
    // }
}
