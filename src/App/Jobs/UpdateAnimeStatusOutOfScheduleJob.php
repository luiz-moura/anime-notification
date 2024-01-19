<?php

namespace App\Jobs;

use Domain\Animes\Actions\UpdateAnimeStatusOutOfScheduleAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Infra\Integration\AnimeApi\DTOs\Collections\AnimesCollection;

class UpdateAnimeStatusOutOfScheduleJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private AnimesCollection $apiAnimes) {}

    public function handle(UpdateAnimeStatusOutOfScheduleAction $action): void
    {
        $action->run($this->apiAnimes);

        logger('ANIMES THAT LEFT THE SCHEDULE, AT ' . now()->format('Y/m/d H:i:s') . ' ' . json_encode(['mal_ids' => $this->apiAnimes->pluck('mal_id')->toJson()]));
    }
}
