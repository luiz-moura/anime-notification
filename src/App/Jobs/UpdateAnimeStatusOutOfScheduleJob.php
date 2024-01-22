<?php

namespace App\Jobs;

use Domain\Animes\Actions\UpdateAnimeStatusOutOfScheduleAction;
use Domain\Animes\DTOs\Collections\AnimesCollection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class UpdateAnimeStatusOutOfScheduleJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private AnimesCollection $animes)
    {
    }

    public function handle(UpdateAnimeStatusOutOfScheduleAction $action): void
    {
        $action->run($this->animes);

        logger('ANIMES THAT LEFT THE SCHEDULE, AT ' . now()->format('Y/m/d H:i:s') . ' ' . json_encode(['mal_ids' => collect($this->animes)->pluck('mal_id')->toJson()]));
    }
}
