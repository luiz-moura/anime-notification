<?php

namespace App\Providers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Infra\Integration\AnimeApi\Contracts\AnimeApiService;
use Infra\Integration\AnimeApi\Jikan\Services\JikanApiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Database\\Factories\\'.class_basename($modelName).'Factory';
        });

        if ($this->app->environment('local')) {
            Mail::alwaysTo('killua@gmail.com');
        }

        $this->app->singleton(
            AnimeApiService::class,
            JikanApiService::class
        );
    }
}
