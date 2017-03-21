<?php

namespace CH\Skeleton\PHPUnit;

use CH\Skeleton\Application;

/**
 * Trait CreateApplication
 *
 * This trait is shared between the standard test case and the Web test case
 * to bootstrap the application correctly.
 */
trait CreateApplication
{
    /**
     * @var     Application
     */
    protected $createdApp = false;

    /**
     * Creates an instance of the application with all the mock dependencies loaded
     * in as well as the package test bootstraps.
     *
     * @return  Application
     */
    public function createApplication()
    {
        if (!$this->createdApp) {
            $app = new Application();
            $app['env'] = Application::ENV_UNITTESTS;
            $app->setEnvironment(Application::ENV_UNITTESTS);

            // Load the bare minimum of what we need:
            $app->register(new \CH\Skeleton\Provider\CoreMockedServiceProvider());

            $this->createdApp = $app;
        }
        return $this->createdApp;
    }

    public function destroyApplication()
    {
        unset($this->createdApp);
        $this->createdApp = false;
    }
}
