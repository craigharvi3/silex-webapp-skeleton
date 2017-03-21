<?php

namespace CH\Skeleton\Tests;

use Pimple\Container;
use CH\Skeleton\Application;
use CH\Skeleton\Controller;
use CH\Skeleton\Locale;
use CH\Skeleton\PHPUnit\TestCase;
use Solution10\Config\Config;
use Symfony\Component\HttpFoundation\Request;

class ControllerTest extends TestCase
{
    /**
     * @return  Controller
     */
    protected function getController()
    {
        return new class extends Controller {
            public function getName(): string
            {
                return 'dummy-controller';
            }

            public function boot(\Silex\Application $app)
            {
            }
        };
    }

    public function testGetDIKey()
    {
        $c = $this->getController();
        $this->assertEquals('silex-webapp-skeleton.controller.dummy-controller', $c->getDIKey());
    }

    public function testGetAction()
    {
        $c = $this->getController();
        $this->assertEquals(
            'silex-webapp-skeleton.controller.dummy-controller:myAction',
            $c->getAction('myAction')
        );
    }

    public function testInitLocale()
    {
        $c = $this->getController();
        $this->assertNull($c->getLocale());

        $request = new Request();
        $request->cookies->set('ckns_locale', 'cy_CY');
        $this->assertInstanceOf(Locale::class, $c->initLocale($request));
        $this->assertInstanceOf(Locale::class, $c->getLocale());
    }

    public function testRegister()
    {
        $c = $this->getController();

        $config = new Config(__DIR__.'/'); // deliberately bogus dir to check it adds.

        $container = new Application();
        $container['config'] = function () use ($config) {
            return $config;
        };
        $container->get('/', function () {
            return '';
        });

        $c->register($container);

        // Check the controller registered itself:
        $this->assertEquals($c, $container[$c->getDIKey()]);

        // Check the config path was added:
        $this->assertTrue(in_array(__DIR__.'/../config', $config->basePaths()));

        // trigger before() to ensure initLocale fired:
        $container->handle(new Request([], [], [], [], [], ['REQUEST_URI' => '/']));
        $this->assertInstanceOf(Locale::class, $c->getLocale());
    }
}
