<?php

namespace App\Jobs;

use Domain\Animes\Actions\UpdateAnimeStatusOutOfScheduleAction;
use Domain\Animes\DTOs\Collections\AnimesCollection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Psr\Log\LoggerInterface;

class UpdateAnimeStatusOutOfScheduleJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 3;

    public function __construct(private AnimesCollection $animes)
    {
    }

    public function handle(
        UpdateAnimeStatusOutOfScheduleAction $action,
        LoggerInterface $logger,
    ): void {
        $action->run($this->animes);

        $logger->info(sprintf('[%s] Animes that left the schedule', __METHOD__), [
            'mal_id' => collect($this->animes)->pluck('mal_id')->toJson(),
        ]);
    }
}
