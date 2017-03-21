<?php

namespace CH\Skeleton\PHPUnit;

/**
 * Class WebTestCase
 *
 * Test case for all controller or web tests. This will bootstrap Tinara correctly
 * so that you have all the mocked dependencies.
 * @codeCoverageIgnore
 */
abstract class WebTestCase extends \Silex\WebTestCase
{
    use CreateApplication;
}
