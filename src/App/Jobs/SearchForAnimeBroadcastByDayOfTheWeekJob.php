<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class SearchForAnimeBroadcastByDayOfTheWeekJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 3;

    public function __construct(private ?int $delayInSeconds = 0)
    {
    }

    public function handle(): void
    {
        collect(Carbon::getDays())->map(function (string $day): void {
            ImportAnimesFromApiJob::dispatch($day);
        });
    }
}
