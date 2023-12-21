<?php

namespace MeridianPulse\Firebomb;

use MeridianPulse\Firebomb\FirebombExceptionHandler;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Contracts\Debug\ExceptionHandler;

class FirebombPhpClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing configuration file. Adjust the path as per your package structure.
        $this->publishes([
            __DIR__ . '/../config/firebombphpclient.php' => config_path('firebombphpclient.php'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(
            ExceptionHandler::class,
            FirebombExceptionHandler::class
        );

        // Merging the package's default configuration. Adjust the path as needed.
        $this->mergeConfigFrom(
            __DIR__ . '/../config/firebombphpclient.php',
            'firebombphpclient'
        );

        // Bind the FirebombPhpExceptionLogger into the service container
        $this->app->bind('firebombphpexceptionlogger', function ($app) {
            return new FirebombPhpExceptionLogger(new Client());
        });
    }
}
