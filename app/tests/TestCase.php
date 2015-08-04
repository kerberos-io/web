<?php

namespace tests;

use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;

abstract class TestCase extends IlluminateTestCase
{
    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;
        $testEnvironment = 'testing';

        return require __DIR__.'/../../bootstrap/start.php';
    }
}
