<?php

namespace CH\Home\Tests;

use CH\Skeleton\PHPUnit\ApplyMockResponses;
use CH\Home\HomeViewController;
use CH\Skeleton\PHPUnit\WebTestCase;

class HomeViewControllerTest extends WebTestCase
{
    public function testGetName()
    {
        $h = new HomeViewController();
        $this->assertEquals("home", $h->getName());
    }

    public function testHandleAction()
    {
        $this->createApplication();

        $client = $this->createClient();

        $this->createdApp
            ->register(new HomeViewController());

        $crawler = $client->request('GET', '/');
        
        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testCacheControl()
    {
        $this->createApplication();

        $client = $this->createClient();

        $this
            ->createdApp
            ->register(new HomeViewController());

        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->headers->hasCacheControlDirective('public'));
        $this->assertTrue($client->getResponse()->headers->hasCacheControlDirective('max-age'));
        $this->assertTrue($client->getResponse()->headers->hasCacheControlDirective('s-maxage'));
        $this->assertTrue($client->getResponse()->headers->hasCacheControlDirective('stale-while-revalidate'));
    }
}
