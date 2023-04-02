<?php

namespace blizni\FXL;

use Illuminate\Support\ServiceProvider;

class FakturaXLProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/fakturaxl.php', 'fakturaxl'
        );

        $this->app->singleton(FakturaXL::class, function() {
            return new FakturaXL();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/fakturaxl.php' => config_path('fakturaxl.php'),
        ]);
    }
}
