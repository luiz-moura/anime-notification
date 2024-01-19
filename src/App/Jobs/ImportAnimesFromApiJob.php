<?php

namespace App\Jobs;

use Domain\Animes\UseCases\ImportAnimesFromApiUseCase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ImportAnimesFromApiJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private string $day) {}

    public function handle(ImportAnimesFromApiUseCase $useCase): void
    {
        $useCase->run(
            $this->day,
            fn($anime) => RegisterAnimeJob::dispatch($anime),
            fn($animes) => UpdateAnimeStatusOutOfScheduleJob::dispatch($animes)
        );
    }
}
