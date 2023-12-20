<?php

namespace App\Jobs;

use Domain\Animes\UseCases\SearchForAnimeBroadcastsUseCase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Infra\Integration\AnimeApi\DTOs\AnimesData as ApiAnimesData;

class SearchForAnimesAiringDailyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(private string $day) {}

    public function handle(SearchForAnimeBroadcastsUseCase $useCase): void
    {
        $useCase->run($this->day)->each(fn (ApiAnimesData $anime) => RegisterAnimeJob::dispatch($anime));
    }
}
