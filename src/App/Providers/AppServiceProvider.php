<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Infra\Integration\AnimeApi\Contracts\AnimeApiService;
use Infra\Integration\AnimeApi\Jikan\Services\JikanApiService;
use Infra\Integration\Notification\Contracts\NotificationService;
use Infra\Integration\Notification\Firebase\FirebaseService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(function (string $modelName): string {
            return 'Database\\Factories\\' . class_basename($modelName) . 'Factory';
        });

        if ($this->app->environment('local')) {
            Mail::alwaysTo('killua@gmail.com');
        }

        $this->app->singleton(AnimeApiService::class, JikanApiService::class);
        $this->app->singleton(NotificationService::class, FirebaseService::class);
    }
}
