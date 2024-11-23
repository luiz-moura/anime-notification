<?php

namespace App\Jobs;

use DateTime;
use Domain\Animes\UseCases\ImportAnimesFromApiUseCase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Queue\InteractsWithQueue;

class ImportAnimesFromApiJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 3;

    public function __construct(private string $day)
    {
    }

    public function handle(ImportAnimesFromApiUseCase $useCase): void
    {
        $useCase->run(
            $this->day,
            fn ($anime): PendingDispatch => RegisterAnimeJob::dispatch($anime),
            fn ($animes): PendingDispatch => UpdateAnimeStatusOutOfScheduleJob::dispatch($animes)
        );
    }

    public function retryUntil(): DateTime
    {
        return now()->addMinutes(1);
    }
}
