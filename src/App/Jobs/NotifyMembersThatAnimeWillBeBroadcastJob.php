<?php

namespace App\Jobs;

use Domain\Animes\Actions\NotifyMembersThatAnimeWillBeBroadcastAction;
use Domain\Animes\DTOs\Models\AnimeModelData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class NotifyMembersThatAnimeWillBeBroadcastJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private AnimeModelData $anime) {}

    public function handle(NotifyMembersThatAnimeWillBeBroadcastAction $notifyMembersThatAnimeWillBeBroadcast): void
    {
        $notifyMembersThatAnimeWillBeBroadcast->run($this->anime);

        logger("ANIME NOTIFICATION SENT: {$this->anime->title}, mal_id: {$this->anime->mal_id}");
    }
}
