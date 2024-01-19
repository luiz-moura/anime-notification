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

    public function __construct() {}

    public function handle(): void
    {
        collect(Carbon::getDays())->map(fn(string $day) => ImportAnimesFromApiJob::dispatch($day));
    }
}
