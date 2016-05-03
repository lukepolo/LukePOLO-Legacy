<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EmitterServiceProvider
 * @package App\Providers
 */
class EmitterServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('emitter', function () {
            return new \App\Services\Emitter;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('emitter');
    }
}