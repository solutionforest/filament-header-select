<?php

namespace SolutionForest\FilamentHeaderSelect\Tests;

use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use SolutionForest\FilamentHeaderSelect\HeaderSelectServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            HeaderSelectServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('app.key', 'base64:Hupx3yAySikrM2/EdkZQNOqQQ0E7QJq0L8HQXJ6BFIE=');
    }
}
