<?php

namespace MailMug\ZentropyLaravel\Tests;

use MailMug\ZentropyLaravel\ZentropyWrapperServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Load your package service provider
     */
    protected function getPackageProviders($app)
    {
        return [
            ZentropyWrapperServiceProvider::class,
        ];
    }

    /**
     * Load package aliases (facades)
     */
    protected function getPackageAliases($app)
    {
        return [
            'Zentropy' => \MailMug\ZentropyLaravel\Facades\Zentropy::class,
        ];
    }
}
