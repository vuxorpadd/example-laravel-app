<?php

namespace App\Providers;

use App\Faker\CustomFakerFactory;
use Faker\Generator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(
                \Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class
            );
        }

        // Add jsx to inertia testing lib
        Config::prepend("inertia.testing.page_extensions", "jsx");

        // Bind interfaces
        $this->app->singleton(Generator::class, function ($app) {
            return $app->make(CustomFakerFactory::class)->create();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
