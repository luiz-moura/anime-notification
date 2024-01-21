<?php

namespace App\Providers;

use Domain\Animes\Contracts\AnimeRepository as AnimeRepositoryContract;
use Domain\Animes\Contracts\AnimeSubscriptionRepository as AnimeSubscriptionRepositoryContract;
use Domain\Animes\Contracts\AnimeTitleRepository as AnimeTitleRepositoryContract;
use Domain\Animes\Contracts\BroadcastRepository as BroadcastRepositoryContract;
use Domain\Animes\Contracts\GenreRepository as GenreRepositoryContract;
use Domain\Animes\Contracts\NotificationTokenRepository as MemberNotificationTokenRepositoryContract;
use Domain\Animes\Contracts\MemberRepository as MemberRepositoryContract;
use Domain\Shared\Medias\Contracts\MediaRepository as MediaRepositoryContract;
use Illuminate\Support\ServiceProvider;
use Infra\Persistente\Eloquent\Repositories\AnimeRepository;
use Infra\Persistente\Eloquent\Repositories\AnimeTitleRepository;
use Infra\Persistente\Eloquent\Repositories\AnimeUserRepository;
use Infra\Persistente\Eloquent\Repositories\BroadcastRepository;
use Infra\Persistente\Eloquent\Repositories\GenreRepository;
use Infra\Persistente\Eloquent\Repositories\MediaRepository;
use Infra\Persistente\Eloquent\Repositories\UserFcmTokenRepository;
use Infra\Persistente\Eloquent\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MemberRepositoryContract::class, UserRepository::class);
        $this->app->bind(AnimeRepositoryContract::class, AnimeRepository::class);
        $this->app->bind(AnimeTitleRepositoryContract::class, AnimeTitleRepository::class);
        $this->app->bind(GenreRepositoryContract::class, GenreRepository::class);
        $this->app->bind(BroadcastRepositoryContract::class, BroadcastRepository::class);
        $this->app->bind(MediaRepositoryContract::class, MediaRepository::class);
        $this->app->bind(AnimeSubscriptionRepositoryContract::class, AnimeUserRepository::class);
        $this->app->bind(MemberNotificationTokenRepositoryContract::class, UserFcmTokenRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {}
}
