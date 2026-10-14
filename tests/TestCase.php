<?php

namespace Medigeneit\GenesisAccounting\Tests;

use Medigeneit\GenesisAccounting\GenesisAccountingServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            GenesisAccountingServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'GenesisAccounting' => \Medigeneit\GenesisAccounting\Facades\GenesisAccounting::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('genesis-accounting.base_url', 'https://stepserp.webnstech.net/Webns/steperp/med/');
        $app['config']->set('genesis-accounting.api_key', 'test-api-key');
        $app['config']->set('genesis-accounting.timeout', 10);
    }
}
