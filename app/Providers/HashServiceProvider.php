<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use \App\libraries\md5Hash;

class HashServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    /**
     * Register the application services.
     *
     */
    public function register()
    {
        $this->app->singleton('hash', function ($app) {
            return new md5Hash();
        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['hash'];
    }
}
