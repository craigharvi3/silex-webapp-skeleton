<?php

namespace CH\Skeleton\PHPUnit;

/**
 * Class TestCase
 *
 * Base test case for your unit tests to run from.
 *
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    use CreateApplication;

    /**
     * Clears all of the mocks to make sure they are ready for next test.
     */
    public function setUp()
    {
        $app = $this->createApplication();
    }
}
