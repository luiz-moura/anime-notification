<?php

namespace App\Jobs;

use Domain\Animes\Actions\NotifyMembersThatAnimeWillBeBroadcastAction;
use Domain\Animes\DTOs\Models\AnimeModelData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Psr\Log\LoggerInterface;

class NotifyMembersThatAnimeWillBeBroadcastJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 3;

    public function __construct(private AnimeModelData $anime)
    {
    }

    public function handle(
        NotifyMembersThatAnimeWillBeBroadcastAction $notifyMembersThatAnimeWillBeBroadcast,
        LoggerInterface $logger,
    ): void {
        $logger->info(sprintf('[%s] Anime notification triggered', __METHOD__), [
            'title' => $this->anime->title,
            'mal_id' => $this->anime->mal_id,
        ]);

        $notifyMembersThatAnimeWillBeBroadcast->run($this->anime);
    }
}
