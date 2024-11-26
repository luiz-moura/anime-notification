<?php

namespace App\Jobs;

use Domain\Animes\UseCases\CreateAnimeUseCase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Infra\Integration\AnimeApi\DTOs\AnimeData as ApiAnimeData;
use Psr\Log\LoggerInterface;

class RegisterAnimeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 3;

    public function __construct(private ApiAnimeData $anime)
    {
    }

    public function handle(
        CreateAnimeUseCase $createAnimeAction,
        LoggerInterface $logger,
    ): void {
        $createAnimeAction->run($this->anime);

        $logger->info(sprintf('[%s] Anime registered', __METHOD__), [
            'title' => $this->anime->title,
            'mal_id' => $this->anime->mal_id,
        ]);
    }
}
