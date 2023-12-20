<?php

namespace App\Jobs;

use Domain\Animes\UseCases\CreateAnimeUseCase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Infra\Integration\AnimeApi\DTOs\AnimesData as ApiAnimesData;

class RegisterAnimeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(private ApiAnimesData $anime) {}

    public function handle(CreateAnimeUseCase $createAnimeAction): void
    {
        $createAnimeAction->run($this->anime);

        logger('REGISTERED AT '. now()->format('Y/m/d H:i:s') . ' ' . json_encode(['mal_id' => $this->anime->mal_id, 'title' => $this->anime->title]));
    }
}
